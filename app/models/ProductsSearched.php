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
    public function __construct(string $search, $page = false) {
        $options = [
            'sql'  => "select * from product where title like :title",
            'params' => [':title' => "%{$search}%"],
            'page' => $page,
            'class' => 'Product'
        ];
        parent::__construct($options);
    }

}

