<?php

namespace app\models;


use core\base\ModelListDb;

class ProductsFiltered extends ModelListDb
{

    public function __construct(int $category_id, array $filter_ids, $page = false) {
        $category = new Category($category_id);
        $category_ids = $category->getChildsIds();

        $sql  = <<<SQL
select * from product
where
  id in (
     select p.id
     from product p
        join attribute_product a on a.product_id = p.id
        join attribute_value v on v.id = a.attr_id
     where
        p.category_id in (:category_ids)
        and a.attr_id in (:filter_ids_1)
     group by p.id
     having count(v.attr_group_id) = (select count(*) from (select distinct attr_group_id cnt from attribute_value where id in (:filter_ids_2)) t)
  )
SQL;

        $options = [
            'sql'  => $sql,
            'params' => [":category_ids" => $category_ids, ":filter_ids_1" => $filter_ids, ":filter_ids_2" => $filter_ids],
            'class' => 'Product',
            'page' => $page,
        ];
        parent::__construct($options);
    }

}