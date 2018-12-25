<?php

namespace app\models;


use core\base\ModelListDb;

class ProductsForCategory extends ModelListDb {

    public function __construct(int $id) {
        $category = new Category($id);
        $ids = $category->getChildsIds();
        $options = [
            'sql'  => "select * from product where category_id in (:ids)",
            'params' => [":ids" => $ids],
            'class' => 'Product',
            'storage' => 'productsForCategory'
        ];
        parent::__construct($options);
    }

}