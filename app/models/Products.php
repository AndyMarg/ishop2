<?php

namespace app\models;

use core\base\ModelListDb;

/**
 * Модель списка товаров
 */
class Products extends ModelListDb {
    
    public function __construct($page = false) {
        $options = [
            'sql'  => "select * from product where hit = :hit and status = :status",
            'params' => [':hit' => '1', ':status' => '1'],
            'page' => $page,
            'count_on_page' => 4,
            'class' => 'Product'
        ];
        parent::__construct($options);
    }
    
}
