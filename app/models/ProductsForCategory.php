<?php

namespace app\models;


use core\base\ModelListDb;

class ProductsForCategory extends ModelListDb {

    public function __construct(int $id, $page = false) {
        $category = new Category($id);
        $ids = $category->getChildsIds();
        $options = [
            'sql'  => "select * from product where category_id in (:ids)",
            'params' => [":ids" => $ids],
            'page' => $page,
            'class' => 'Product',
        ];
        parent::__construct($options);
    }

}