<?php

namespace app\models;


use core\base\ModelListDb;

class Orders extends ModelListDb
{
    public function __construct($page = false) {

        $sql = <<<SQL
select o.id, u.name user, o.status, o.date, o.update_at, round(c.summa*r.value,2) summa , r.code currency_code
from `order` o
  join `user` u on u.id = o.user_id
  join currency r on r.code = o.currency
  join (select order_id, sum(qty * price) summa from order_product group by order_id) c on c.order_id = o.id
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