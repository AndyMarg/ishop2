<?php

namespace app\models;

use core\base\ModelListDb;

/**
 * Список рисунков галереи
 */
class GalleryImages extends ModelListDb {
    
    public function __construct(int $id) {
        $options = [
            'sql'  => "select * from gallery where product_id = :product_id",
            'params' => [':product_id' => $id],
            'class' => 'GalleryImage'
        ];
        parent::__construct($options);
    }
    
}
