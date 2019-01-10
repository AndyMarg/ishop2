<?php

namespace app\models;


use core\base\ModelListDb;

class OrderItems extends ModelListDb
{
    public function __construct(int $order_id) {
        $options = [
            'sql'  => "select * from order_product where order_id = :order_id",
            'params' => [':order_id' => $order_id],
            'class' => 'OrderItem'
        ];
        parent::__construct($options);
    }

}