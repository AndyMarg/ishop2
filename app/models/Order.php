<?php

namespace app\models;


use core\base\ModelDb;

class Order extends ModelDb
{

    /**
     * Инициализируем заказ из формы или БД
     * @param array|string $data Массив данных из формы или id заказа для запроса данных из БД
     * @throws \Exception
     */
    public function __construct($data)
    {
        $options = [
            'sql' => "select * from user where id = :id",
            'params' => [':id' => $data],
            'storage' => 'order',
            'table' => "`order`",
            'insert_fields' => ['user_id', 'currency', 'note']
        ];

        parent::__construct($data, $options);
    }


}