<?php

namespace core\libs;

trait TSingleton {
    
    private static $instance;
    
     /**
     * Делаем недоступным создание, клонирование или создание через десериализацию
     */
    private function __construct() {}
    private function __clone() {}

    /**
     * Единственный экземпляр конфигурации
     * @return object
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }

}
