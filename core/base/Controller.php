<?php

namespace core\base;

/**
 * Базовый клас контроллера
 */
abstract class Controller {
    

    private $route;     // маршрут к контроллеру
    private $view;      // текущее представление

    // необходим ли рендеринг страницы?
    // (не нужен, если в методе контроллера ...Action() идет внутренне перенаправление (forwarding) по другому маршруту)
    protected $rendering = true;
    
    public function __construct($route) {
        $this->route = $route;
        $this->view = new View($this);
    }
    
    public function getView() { return $this->view; }
    public function getRoute() { return $this->route; }
    public function getControllerName() { return $this->route['controller']; }
    public function getActionName() { return $this->route['action']; }
    public function isAdmin() { return isset($this->route['admin']); }
    
    /**
     * Подготавливаем данные и вызываем нужное представление
     * @throws \Exception
     */
    public function dispatch() {
        $this->callAction();
        if ($this->rendering) {
            if ($this->isAjax()) {
                $this->getView()->setLayout(false);
            }
            $this->view->render();
        }
    }
    
    /**
     * True, если запрос ajax
     *
     * @return bool
     */
    protected function isAjax() {
        $is_ajax = filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH');
        return isset($is_ajax) && $is_ajax === 'XMLHttpRequest';
    }
    
    /**
     * Выдаем ошибку ajax
     * @param string $message
     * @param int $errorCode
     */
    protected function errorAjax(string $message, $errorCode = 1000) {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => $message, 'code' => $errorCode)));
    }

    /**
     * Внутренне перенаправление по другому маршруту
     * @param string $url URL для маршрутизации
     * @throws \Exception
     */
    protected function forward(string $url)
    {
        $this->rendering = false;
        Application::getRouter()->dispatch($url);
    }
    
    /**
     * Вызываем метод действия в соответствии с маршрутом для подготовки данных для представления
     *
     * @throws \Exception
     */
    private function callAction() {
        $action = $this->route['action'] . 'Action';
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            throw new \Exception("Метод не найден: " . get_class($this) .  "::{$action}", 500);
        }
    }
    
    
}
