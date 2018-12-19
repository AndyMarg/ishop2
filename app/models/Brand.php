<?php

namespace app\models;

/**
 * Брэнд
 */
class Brand extends AppModel {

    /**
     * КОНСТРУКТОР
     * @param int $data Массив данных модели брэнда или ид модели брэнда для получения данных из БД
     * @throws \Exception
     */
    public function __construct($data) {
        $id = gettype($data) === 'integer' ? $data : NULL;
         $options = [
            'sql' => 'select * from brand where id = :id',
            'params' => [':id' => $id]
        ];
        parent::__construct($data, $options);
    }
    
}
