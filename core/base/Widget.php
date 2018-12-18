<?php

namespace core\base;

use core\libs\Utils;

/**
 * Абстрактный класс виджета
 */
abstract class Widget {
   
    private $name;
    private $tpl;
    private $js;
    private $data = [];
            
    private $cache_key_prefix = 'widget';
    private $cachePeriod = false;
        
    /**
     * Конструктор
     * @param string $name Имя виджета
     */
    public function __construct(string $name, $options = []) {
        $this->name = $name;
        $this->tpl = Utils::getRoot() . str_replace('{widget}', $name,  Application::getConfig()->dirs->widget_tpls) . '/'.  $name . '.tpl.php';
        $this->js =  Utils::getRoot() . str_replace('{widget}', $name,  Application::getConfig()->dirs->widget_scripts) . '/'.  $name . '.js';
        // устанавливаем атрибуты объекта
        foreach ($options as $key => $value) {
            if (key_exists($key, get_object_vars($this))) {
                $this->$key = $value;
            }
        }
        $this->run();
    }
    
    /**
     * Возвращает имя виджета
     * @return type
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Установить данные для виджета
     * @param type $data
     */
    protected function setData($data) {
        $this->data = $data;
    }

    /**
     * Получить данные для виджета
     * @param type $data
     */
    protected function getData() {
        return $this->data;
    }
    
    /**
     * Возвращает путь к основному шаблону виджете
     * @return type
     */
    protected function getTpl() {
        return $this->tpl;
    }

    /**
      * Виртуальный метод. Исполнение виджета
      */
    protected function  run() {
       echo $this->getHtml(); 
    }
    
    /**
     * Выводит в поток вывода шаблон виджета.
     * Может быть перекрыт в наследниках.
     */
    protected function outputTemplate() {
        // сформировать локальные переменные
        extract($this->getData());
        return require_once $this->tpl; 
    }

    /**
     * Возвращаем html разметку виджета
     * @return type
     */
    private function getHtml() {
        // сформировать локальные переменные
        extract($this->getData());
        // получить контент из кэша
        $content = $this->htmlFromCache(); 
        // в кэше ничего нет - формируем снова
        if (!$content) {
            ob_start();
            // подключаем шаблон виджета
            $this->outputTemplate();
            //  подключаем скрипты виджета
            $file = $this->js;
            if (is_file($file)) { 
                echo "<script>\n";
                require_once $file;
                echo "</script>\n";
            }   
            $content = ob_get_clean();
            $this->htmlToCache($content);
        }    
        return $content;
     }
     
     /**
      * Возвращает разметку html из кэша
      * @return mixed
      */
     private function htmlFromCache() {
         $content = Cache::load('widget_' . $this->name);
         return $content;
     }
     
     /**
      * Сохраняем разметку html в кэше
      * @param string $content
      */
     private function htmlToCache(string $content) {
         if ($this->cachePeriod) {
             Cache::save($this->cache_key_prefix . '_' . $this->name, $content, $this->cachePeriod);
         }
     }
     
}
