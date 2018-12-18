<?php

namespace core\base;

use core\libs\Utils;

/**
 * Базовый класс View
 */
class View {
    
    // контроллер - владелец вида
    private $controller;
    // массив переменных для view
    private $data = [];
    // массив метаданных для view
    private $meta = [];
    // шаблон html
    private $layout;
    // js скрипты 
    private $scripts = [];
    
    public function __construct(Controller $controller, $layout = '') {
        $config = Application::getConfig();
        $this->controller = $controller;
        // шаблон html
        if ($layout ===  false)  {
            $this->layout = false;
        } else {
            $this->layout = $layout ? : Application::getConfig()->defaults->layout;
        }
        // мета
        $this->meta['title'] = $config->defaults->meta->title;
        $this->meta['decription'] = $config->defaults->meta->description;
        $this->meta['keywords'] = $config->defaults->meta->keywords;
    }
    
    public function getController() { return $this->controller; }
    public function setController(Controller $controller) { $this->controller = $controller; }     

    public function getLayout() { return $this->layout; }
    public function setLayout($layout) { $this->layout = $layout; }

    /**
     * Установить массив переменных для view
     * @param type $data
     */  
    public function setData($data) { $this->data = $data; }
    
    /**
     * Установить метаданные
     * @param string $title
     * @param string $description
     * @param string $keywords
     */
    public function setMeta($title = '', $description = null, $keywords = null) {
        
        $this->meta['title'] = empty($title) ? '' : $title;
        $this->meta['description'] = empty($description) ? '' : $description;
        $this->meta['keywords'] = empty($keywords) ? '' : $keywords;
    }
    
    /**
     * Ренденрим html-разметку для представления
     * @throws \Exception
     */
    public function render() {
        // распаковать элементы массивав переменные
        if (!empty($this->data)) {
            extract($this->data);
        }
        // получить контент представления
        $file = $this->getViewFilePath();
        if (is_file($file)) {
            ob_start();
            require $file;
            $content = ob_get_clean();
            // получить контент шаблона html
            if (false !== $this->layout) {
                $file = $this->getLyaoutFilePath();
                if (is_file($file)) {
                    // вырезаем скрипты из вида, впоследствии вставим их в шаблоне через insertScripts()
                    $content = $this->cutScripts($content);
                    require $file;
                } else {
                    throw new \Exception("Не найден шаблон HTML: {$file}",500);
                }
            } else {
                echo $content;
            }
        } else {
            throw new \Exception("Не найдено представление: {$file}",500);
        }
    }
    
    /**
     * Возвращает путь к предсталениz в файловой системе
     * @return type
     */
    private function getViewFilePath() {
        $config = Application::getConfig();
        $adminPathPrefix = $this->controller->isAdmin() ? $config->dirs->admin . '/' : '';
        return  Utils::getRoot() . $config->dirs->views . '/' . $adminPathPrefix . 
                $this->controller->getControllerName() . '/' . 
                $this->controller->getActionName() . '.php';
    }
    
    /**
     * Возвращает путь к шаблону html в файловой системе
     * @return type
     */
    private function getLyaoutFilePath() {
        $config = Application::getConfig();
        return Utils::getRoot() . $config->dirs->layouts . '/' . $this->layout . '.php';
    }
    
    /**
     * Возвращает html-разметку метаданных
     * @return type
     */
    private function getMetaHtml()   {
        return 
            "<title>{$this->meta['title']}</title>" . PHP_EOL .
            "<meta name=\"description\" content=\"{$this->meta['description']}\">" . PHP_EOL .
            "<meta name=\"keywords\" content=\"{$this->meta['keywords']}\">\n" . PHP_EOL;
    }
    
    /**
     * Вырезаем скрипты и помещаем в массив $this->scripts
     * @param type $content
     * @return type
     */
    private function cutScripts($content) {
        $pattern = "#<script.*?>.*?</script>#si";
        preg_match_all($pattern, $content, $this->scripts);
        if (!empty($this->scripts)) {
            $content = preg_replace($pattern, '', $content);
        }
        return $content;
    }
    
    /**
     Для вывода предварительно вырезанных скриптов в шаблоне
     */
    protected function insertScripts() {
        foreach ($this->scripts[0] as $script) {
            echo "{$script}\n";
        }
    }
}
