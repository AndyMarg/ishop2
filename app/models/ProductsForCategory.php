<?php

namespace app\models;


use core\base\ModelListDb;

class ProductsForCategory extends ModelListDb {

    public function __construct(int $id, int $first_record = 0, int $count_records = 0) {
        $category = new Category($id);
        $ids = $category->getChildsIds();
        $options = [
            'sql'  => "select * from product where category_id in (:ids)",
            'params' => [":ids" => $ids],
            'limit' => (($first_record >= 0) && ($count_records > 0)) ? [$first_record, $count_records] : [],
            'class' => 'Product',
//            'storage' => 'productsForCategory'
        ];
        parent::__construct($options);
    }

}