<?php

namespace core\base;

use core\libs\TSingleton;

/**
 * Хранилище постоянных объектов. Singleton
 */
class Storage {
    
    use TSingleton;
    
    private $data = [];
    
    /**
     * Установит значение элемента
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value) {
        $this->data[$name] = $value;
    }
    
    /**
     * Получить значение элемента
     * @param string $name
     * @return mixed
     */
    public function get($name) {
        if (key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return false;
    }
    
    /**
     * Удилить элемент
     * @param string $name
     */
    public function remove($name) {
        unset($this->data[$name]);
    }
    
    /**
     * Очистить хранилище
     */
    public function clear() {
        foreach ($this->data as $name => $value) {
            $this->remove($name);
        }
    }
    
    /**
     * Получить все элементы
     * @return array
     */
    public function getAll() {
        return $this->data;
    }
}
