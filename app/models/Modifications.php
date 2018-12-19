<?php

namespace app\models;

use core\base\ModelListDb;

/**
 * Список модификаций товара
 */
class Modifications extends ModelListDb {
    
    public function __construct(int $id) {
        $options = [
            'sql'  => "select * from modification where product_id = :product_id",
            'params' => [':product_id' => $id],
            'class' => 'Modification',
            'storage' => 'modifications'
        ];
        parent::__construct($options);
    }
    
}
