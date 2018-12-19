<?php

namespace app\models;

use core\base\ModelListDb;

/**
 * Модель списка товаров
 */
class Products extends ModelListDb {
    
    public function __construct() {
        $options = [
            'sql'  => "select * from product where hit = :hit and status = :status limit 8",
            'params' => array(':hit' => '1', ':status' => '1'),
            'class' => 'Product'
        ];
        parent::__construct($options);
    }
    
}
