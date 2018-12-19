<?php

namespace app\models;

use core\base\ModelListDb;

/**
 * Список брэндов
 */
class Brands extends ModelListDb {
    
    public function __construct() {
        $options = [
            'sql'  => "select * from brand limit 3",
            'class' => 'Brand'
        ];
        parent::__construct($options);
    }
    
}
