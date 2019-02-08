<?php

namespace app\models;


use core\base\ModelDb;

/**
 * Class OrderItem Элемент заказа
 * @package app\models
 */
class OrderItem extends ModelDb
{
    public function __construct($data)
    {
        $options = [
            'sql' => "select op.*, qty*price summa from order_product op where id = :id",
            'params' => [':id' => $data],
            'storage' => 'order_item',
            'table' => "`order_product`",
            'insert_fields' => ['order_id', 'product_id', 'qty', 'title', 'price']
        ];

        parent::__construct($data, $options);
    }

}