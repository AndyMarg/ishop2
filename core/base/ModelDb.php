<?php

namespace core\base;

/**
 * Класс модели с данными из БД
 */
abstract class ModelDb extends Model {
    
    private $options = [];  //  свойства модели

    /**
     * ModelDb constructor.
     * @param mixed $data Массив данных объекта модели, ид объекта модели или строка,
     *      однозначно идентифицирующая объект модели для получения данных из БД
     * @param array|null $options Свойства модели
     * @throws \Exception
     */
    public function __construct($data, array $options = null) {
        if (isset($options)) {
            $this->options = $options;
        }
        // пробуем получить из хранилища, если задана установка для хранилища 
        if (gettype($data) !== 'array' && !empty($options['storage'])) {
             $fromStorage = Application::getStorage()->get($options['storage']);
        }
        // если их хранилища не получили 
        if (empty($fromStorage)) {
            // если передан не массив данных, загружаем из БД 
            if (gettype($data) !== 'array') {
                $data = $this->load($data);
            }
        } else {
            $data = $fromStorage;
        }
        // сохраняем в хранилище, если задана установка для хранилища 
        if (!empty($data) && !empty($options['storage'])) {
             Application::getStorage()->set($options['storage'], $data);
        }
        parent::__construct($data);
    }

    /**
     * Получить данные объекта модели из БД
     * @param mixed $param
     *      ид объекта модели или строка, однозначно идентифицирующая объект модели 
     *      для получения данных из БД
     * @return array Массив данных объекта модели из БД
     * @throws \Exception
     */
    private function load($param) {
        switch (gettype($param)):
            case 'integer':    // передан ид модели
                if (!key_exists('sql', $this->options) || empty($this->options['sql'])) {
                    throw new \Exception("Not defined SQL for model");
                }
                $sql = $this->options['sql'];
                $params = [];
                if (key_exists('params', $this->options) && !empty($this->options['params'])) {
                    $params = $this->options['params'];
                }
                break;
            case 'string':     // передана строка, однозначно идентифицирующая модель
                if (!key_exists('sql2', $this->options) || empty($this->options['sql2'])) {
                    throw new \Exception("Not defined SQL for model");
                }
                $sql = $this->options['sql2'];
                $params = [];
                if (key_exists('params2', $this->options) && !empty($this->options['params2'])) {
                    $params = $this->options['params2'];
                }
                break;
            default:
                throw new \Exception("Invalid argument for identify db result");
                break;
        endswitch;
        $result = Application::getDb()->query($sql, $params);
        return !empty($result) ? $result[0] : [];
    }
    
    /**
     * Сохраняем данные модели в БД
     */
    public function save() {
        
    }
    
}
