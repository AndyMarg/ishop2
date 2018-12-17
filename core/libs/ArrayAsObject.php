<?php

namespace core\libs;

/**
 * Массив как объект. Доступ с несущестующему свойству через __SET
 */
class ArrayAsObject implements \IteratorAggregate {

    private $array;
    
    public function __construct(array $array) {
        $this->array = $array;
    }

    /**
     * Доступ к несуществующему свойству объекта
     * 
     * @param string $property Имя свойства
     * @return mixed ArrayAsObject, если элемент массива сам по себе массив, или значение элемента
     * @throws \Exception Если такого элемента массива не существует
     */
    public function __get($property) {
        if (!array_key_exists($property, $this->array)) {
            throw new \Exception('Not found property: ' . $property);
        } else {
            if(is_array($this->array[$property])) {
                return new ArrayAsObject($this->array[$property]);
            } else {
                return $this->array[$property];
            }    
        }
    }
    
    public function __isset($property) 
    {
        return isset($this->array[$property]);
    }

    public function __unset($property) 
    {
        unset($this->array[$property]);
    }

    /**
     * @return array Возвращает исходный массив данных
     */
    public function asArray() {
        return $this->array;
    }
    
    /**
     * Возвращает итератор для доступа к объекту как к массиву
     * @return \core\libs\IteratorBase
     */
    public function getIterator() {
        return new IteratorBase($this->array);
    }

    /**
     * Проверка, что объект не пустой
     * @return bool
     */
    public function isEmpty() {
        return count($this->array) === 0;
    }
    
    public function search(string $name, $value) {
        foreach ($this->array as $item) {
            if($item->$name == $value) {
                return $item;
            }
        }
        return false;
    }
}
