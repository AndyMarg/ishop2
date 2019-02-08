<?php

namespace app\models;


use core\base\ModelListDb;

class Orders extends ModelListDb
{
    public function __construct($page = false) {

        $sql = <<<SQL
select o.*, round(c.summa*r.value,2) summa, c.cnt, o.currency currency_code, u.name user
from `order` o
       join `user` u on u.id = o.user_id
       join currency r on r.code = o.currency
       join (select order_id, sum(qty * price) summa, count(*) cnt from order_product group by order_id) c on c.order_id = o.id
order by o.status, o.id
SQL;
        $options = [
            'sql'  => $sql,
            'page' => $page,
            'count_on_page' => 5,
            'class' => 'Order'
        ];
        parent::__construct($options);
    }

}