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
     * @param array $rules Массив правил валидации модели
     * @throws \Exception
     */
    public function __construct($data, array $options = null, $rules = []) {
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
        parent::__construct($data, $rules);
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
        return $result ? $result[0] : [];
    }
    
    /**
     * Сохраняем данные модели в БД
     */
    public function save() {
        if (key_exists('insert_fields', $this->options) && !empty($this->options['insert_fields'])) {
            $fields = $this->options['insert_fields'];
        }
        if (!isset($fields)) return false;
        if (key_exists('table', $this->options) && !empty($this->options['table'])) {
            $table = $this->options['table'];
        }
        if (!isset($table)) return false;

        foreach ($this->asArray() as $field => $value) {
            if (in_array($field, $fields)) {
                $params[$field] = $value;
            }
        }

        $sql = "insert into {$table}(";
        foreach ($params as $field => $value) {
            $sql .= $field . ',';
        }
        $sql = substr($sql, 0, strlen($sql)-1) . ') values(';
        foreach ($params as $field => $value) {
            $sql .= ':' . $field . ',';
        }
        $sql = substr($sql, 0, strlen($sql)-1) . ')';

        $result = Application::getDb()->execute($sql, $params);

        $this->data['id'] = Application::getDb()->getLastID();

        return $result;
    }

    /**
     * Переопределяем метод суперкласса, добавляя валидацию данных в БД
     * @return bool True, если данные модели корректны
     */
    public function validate()
    {
        $result = parent::validate();
        if (key_exists('unique_fields', $this->options) && !empty($this->options['unique_fields'])) {
            $fields = $this->options['unique_fields'];
        }
        if (!isset($fields)) return $result;
        if (key_exists('table', $this->options) && !empty($this->options['table'])) {
            $table = $this->options['table'];
        }
        if (!isset($table)) return $result;

        foreach ($this->asArray() as $field => $value) {
            if (key_exists($field, $fields)) {
                $data[$field] = $value;
            }
        }

        foreach ($data as $field => $value) {
            $sql = "select exists(select * from {$table} where {$field} = :{$field}) as result from dual";
            $params = [":{$field}" => $data[$field]];
            $exist = Application::getDb()->query($sql, $params)[0]['result'];
            if ($exist) {
                $this->errors['unique'][] = $fields[$field];
            }
        }

        $result = empty($this->errors);

        return $result;
    }

    /**
     * @return bool True, если модель сохранена в БД
     */
    public function isPersisted()
    {
        return isset($this->data['id']);
    }
}
