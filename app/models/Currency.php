<?php

namespace app\models;

/**
 * Валюта
 */
class Currency extends AppModel {

    /**
     * КОНСТРУКТОР
     * @param mixed $data Массив данных модели валюты или ид модели валюты для получения данных из БД
     * @throws \Exception
     */
    public function __construct($data) {
        $id = gettype($data) === 'integer' ? $data : NULL;
         $options = [
            'sql' => 'select * from currency where id = :id',
            'params' => [':id' => $id]
        ];
        parent::__construct($data, $options);
    }
    
    /**
     * Получить код текущей валюты из куки
     * @return string
     */
    public static function getCurrentCode() {
        $code = filter_input(INPUT_COOKIE, 'currency');
        return isset($code) ? $code : false;
    }
}
