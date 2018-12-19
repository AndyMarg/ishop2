<?php

namespace core\base;

/**
 * Маршрутизатор. Singleton
 */
class Router {
    
    use \core\libs\TSingleton;
    
    /**
     * Таблица маршрутизации
     * @var array Регулярка соответствия uri => [controller, action]
     */
    private $routes = [];

    /**
     * Информация о маршруте
     * @var array [controller, action]
     */
    private $route = [];
    
    public function getRoutes(): array { return $this->routes; }
    public function getRoute(): array { return $this->route; }

    /**
     * Добавляет (изменяет) маршрут в таблице маршрутизации
     * @param string $regexp Регулярка соответствия uri 
     * @param array $route [controller, action]
     */
    public function add(string $regexp, $route = []) {
        $this->routes[$regexp] = $route;
    }
    
    /**
     * Инициализируем маршруты приложения и админки
     */
    public function Init() {
        // настроить пользовательские маршруты (перед остальными)
        $path_user = Application::getConfig()->routes->user;
        foreach ($path_user as $path) {
            $this->add($path['regexp'], ['controller' => $path['controller'], 'action' => $path['action']]);
        }
        
        // пути к свойствам маршрутов по умолчанию
        $path_base = Application::getConfig()->routes->default->base;
        $path_dyn = Application::getConfig()->routes->default->dynamic;

        // добавить маршруты админки 
        // (перед маршрутами приложения по умолчанию, так как регулярка более специфичная)
        $admin_uri = Application::getConfig()->admin->uri;
        $this->add(substr_replace($path_base->regexp, $admin_uri , 1, 0), 
                ["controller" => $path_base->controller, "action" => $path_base->action, "admin" => true]);
        $this->add(substr_replace($path_dyn->regexp, $admin_uri . '/', 1, 0), ["admin" => true]);
        // добавить маршруты приложения
        $this->add($path_base->regexp, ["controller" => $path_base->controller, "action" => $path_base->action]);
        $this->add($path_dyn->regexp);
    }
    
    /**
     * Деспетчиризуем url на вызов метода контроллера
     * @param string $uri
     * @throws \Exception
     */
    public function dispatch($uri) {
        $config = Application::getConfig();
        if ($this->matchRoute($uri)) {
            $adminPathPrefix = (isset($this->route['admin'])) ? $config->dirs->admin : '';
            // путь к контроллеру
            $controllerPath = $this->isWidget($this->route['controller']) ?
                    str_replace('{widget}', lcfirst($this->route['controller']), $config->dirs->widget_controllers) :
                    $config->dirs->controllers;
            $controllerClass = str_replace('/', '\\', $controllerPath . $adminPathPrefix . '/' .  $this->route['controller'] . 'Controller');
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass($this->route);
                $controller->dispatch();
            } else {
                throw new \Exception("Контроллер не найден: {$controllerClass}", 500);
            }
        } else {
            throw new \Exception("Страница не найдена", 404);
        }
    }
    
    /**
     * Формируем маршрут [controller, action] на основе совпадения uri с шаблоном регулярки
     * @param string $uri
     * @return boolean true, если совпадение в таблице маршрутов найдено
     */
    private function matchRoute($uri) {
        foreach ($this->routes as $pattern => $route) {
            $matches = [];
            if (preg_match("#{$pattern}#", $uri, $matches)) {
                // цикл ниже сработает только для uri типа "/controller/action" (или только "/controller")
                foreach ($matches as $key => $value) {
                     if (is_string($key)) {
                         $route[$key] = $value;
                     }
                }
                // цикл ниже сработает только для uri типа "/controller"
                if (!array_key_exists('action', $route)) {
                    $route['action'] = Application::getConfig()->routes->default->dynamic->action;
                }
                $route['controller'] = $this->toCamelCase($route['controller']);
                $route['action'] = $this->toCamelCase($route['action'], true);
                $this->route = $route;
                return true;
            }
        }
        return false;
    }
    
    /**
     * Перевод строки, разделенной "-" в CamelCase с удалением "-" 
     * @param string $name
     * @param bool $firstCharLower Если true - первый символ в нижнем регистре
     * @return string string
     */
    private function toCamelCase(string $name, bool $firstCharLower = false) {
        $result = str_replace('-', '', ucwords($name, '-'));
        $result = ($firstCharLower) ? lcfirst($result) : $result;
        return $result;
    }
    
    /**
     * True, если это контроллер виджета
     * @param string $controller Имя контроллера
     * @return bool
     */
    private function isWidget($controller) {
        return in_array(strtolower($controller), Application::getConfig()->widgets->asArray());
    }
    
}
