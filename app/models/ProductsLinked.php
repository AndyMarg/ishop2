<?php

namespace app\models;

use core\base\ModelListDb;

/**
 * Список связанных продуктов
 */
class ProductsLinked extends ModelListDb {

    public function __construct(int $id) {
        $options = [
            'sql'  => "select p.* from product p join related_product r on r.related_id = p.id where r.product_id = :id limit 3",
            'params' => [":id" => $id],
            'class' => 'Product',
            'storage' => 'productsLinked'
        ];
        parent::__construct($options);
    }
    
}
