<?php

namespace app\models;

use core\base\ModelListDb;

class ProductsSearched extends ModelListDb
{
    /**
     * ProductsSearched constructor.
     * @param string $search Строка для поиска товаров по шаблону названия
     * @throws \Exception
     */
    public function __construct(string $search) {
        $options = [
            'sql'  => "select * from product where title like :title",
            'params' => [':title' => "%{$search}%"],
            'class' => 'Product'
        ];
        parent::__construct($options);
    }

}

