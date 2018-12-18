<?php

use core\base\ModelList;
use core\base\Application;

namespace core\base;

/**
 * Список моделей из ДБ
 */
class ModelListDb extends ModelList {

    private $options = [];      // свойства модели
    private $source = [];       // данные из базы в виде массива (индексирован по порядку)
    
    /**
     * КОНСТРУКТОР
     * @param array $options Настройки модели (sql и т.д.)
     */
    public function __construct(array $options) {
        $this->options = $options;
        // пробуем получить из хранилища, если задана установка для хранилища 
        if (isset($options['storage'])) {
             $this->source = Application::getStorage()->get($options['storage']);
        }
        // если их хранилища не получили, получаем из БД
        if (empty($this->source)) {
            $this->source = $this->load();
        }
        // сохраняем в хранилище, если задана установка для хранилища 
        if (!empty($this->source) && isset($options['storage'])) {
             Application::getStorage()->set($options['storage'], $this->source);
        }
        parent::__construct($this->source, $options['class'] );
    }
    
    /**
     * Загружаем данные списка моделей из БД
     */
    private function load() {
        if (!key_exists('sql', $this->options) || empty($this->options['sql'])) {
            throw new Exception("Not defined SQL for model list");
        }
        $sql = $this->options['sql'];
        $params = [];
        if (key_exists('params', $this->options) && !empty($this->options['params'])) {
            $params = $this->options['params'];
        }
        return Application::getDb()->query($sql, $params);
    }
    
    /**
     * Возвращает массив данных из базы
     * @param bool $indexedById  Индексировать массив идентификаторами данных из базы
     * @return type Массив данных из базы
     */
    public function asArray(bool $indexedById = false) {
        if ($indexedById) {
            foreach ($this->source as $item) {
                $temp[$item['id']] = $item;
            }
        } else {
            $temp = $this->source;
        }
        return $temp;
    }
}

