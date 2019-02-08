<?php

namespace app\models;


use core\base\ModelListDb;

class OrderItems extends ModelListDb
{
    public function __construct(int $order_id) {
        $options = [
            'sql'  => "select op.*, round(qty*price,2) summa from order_product op where order_id = :order_id",
            'params' => [':order_id' => $order_id],
            'class' => 'OrderItem'
        ];
        parent::__construct($options);
    }

}