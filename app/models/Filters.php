<?php

namespace app\models;


use core\base\ModelListDb;

class Filters extends ModelListDb
{
    public function __construct() {
        $options = [
            'sql'  => "select g.title filter_name, g.id filter__id, v.id, v.value " .
                      "from attribute_group g join attribute_value v on v.attr_group_id = g.id;",
            'class' => 'Filter'
        ];
        parent::__construct($options);
    }

}