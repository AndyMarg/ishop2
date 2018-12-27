<?php

namespace app\models;

use core\base\ModelListDb;

/**
 * Модель списка товаров
 */
class Products extends ModelListDb {
    
    public function __construct(int $first_record = 0, int $count_records = 0) {
        $options = [
            'sql'  => "select * from product where hit = :hit and status = :status",
            'params' => [':hit' => '1', ':status' => '1'],
            'limit' => (($first_record > 0) && ($count_records > 0)) ? [$first_record, $count_records] : [],
            'class' => 'Product'
        ];
        parent::__construct($options);
    }
    
}
