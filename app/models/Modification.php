<?php

namespace app\models;

/**
 * Модификация товара
 * @property mixed id
 * @property mixed price
 * @property mixed title
 */
class Modification extends AppModel{

    /**
     * КОНСТРУКТОР
     * @param mixed $data Массив данных модели модификации товара или ид модели модификации товара для получения данных из БД
     * @throws \Exception
     */
    public function __construct($data) {
        $id = gettype($data) === 'integer' ? $data : NULL;
         $options = [
            'sql' => 'select * from modification where id = :id',
            'params' => [':id' => $id]
        ];
        parent::__construct($data, $options);
    }
    
}
