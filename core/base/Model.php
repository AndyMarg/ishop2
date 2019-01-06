<?php

namespace core\base;

use Valitron\Validator;

/**
 * Базовый класс модели
 */
abstract class Model {
    
    protected $data = [];     // данные модели
    private $rules = [];    // правила валидации модели
    protected $errors = [];   // ошибки валидации

    /**
     * КОНСТРУКТОР
     * @param array $data Массив данных модели
     * @param array $rules Правила валидации модели
     */
    public function __construct(array $data = [], array $rules = []) {
        $this->data = $data;
        $this->rules = $rules;
    }
    
    /**
     * Доступ к несуществующему свойству объекта результат вызова публичного метода get{$Property}()
     * @param string $property Имя свойства или часть имени публичного метода get{$Property}()
     * @return mixed Значение свойства (элемента массива, где ключ - имя свойства) или результат вызова метода
     * @throws \Exception Если такого элемента массива не существует
     */
    public function __get($property) {
        $method = 'get' . ucfirst($property);
        if (!array_key_exists($property, $this->data) && !method_exists($this, $method)) {
            throw new \Exception("Not found property \"{$property}\" or public method \"{$method}\"");
        } 
        if (isset($this->data[$property])) {
            return $this->data[$property];
        } elseif (method_exists($this, $method)) {
            return $this->$method();
        } else {
            return false;
        }
    }
    
    /**
     * Установка несуществующего свойства объекта
     * @param string $property  Имя свойства
     * @param mixed $value Значение свойства
     * @throws \Exception
     */
    public function __set($property, $value) {
        if (!array_key_exists($property, $this->data)) {
            throw new \Exception("Not found property \"{$property}\"");
        } 
        $this->data[$property] = $value;
    }
    
    public function __isset($property) {
        return isset($this->data[$property]);
    }

    public function __unset($property) {
        unset($this->data[$property]);
    }
    
    /**
     * Данные модели в виде массива
     * @return array
     */
    public function asArray() {
        return $this->data;
    }

    /**
     * Действительна ли модель
     * @return bool true, есди данные имеются (например, из бд)
     */
    public function isEmpty() {
        return empty($this->data);
    }

    /**
     * Валидация данных модели
     */
    public function validate()
    {
        Validator::lang('ru');
        $validator = new Validator($this->data);
        $validator->rules($this->rules);
        if ($validator->validate()) {
            return true;
        } else {
            $this->errors = $validator->errors();
            return false;
        }
    }

    /**
     * @return array Ошибки валидации
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
