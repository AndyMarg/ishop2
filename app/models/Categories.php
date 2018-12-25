<?php


namespace app\models;

use core\base\ModelListDb;

/**
 * Список категорий товаров
 */
class Categories extends ModelListDb {
    
    public function __construct() {
        $options = [
            'sql'  => "select * from category",
            'class' => 'Category',
            'storage' => 'categories'
        ];
        parent::__construct($options);
    }
   
}
