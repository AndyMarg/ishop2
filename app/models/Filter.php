<?php

namespace app\models;


use core\base\ModelDb;

/**
 * Class Filter Значение фильтра
 * @package app\models
 */
class Filter extends ModelDb
{

    /**
     * Filter constructor.
     * @param $data
     * @throws \Exception
     */
    public function __construct($data)
    {
        $id = gettype($data) === 'integer' ? $data : NULL;
        $options = [
            'sql' => "select v.id, v.value, g.id filter__id, g.title filter_name  " .
                     "from attribute_group g join attribute_value v on v.attr_group_id = g.id where g.id = :id;",
            'params' => [':id' => $id],
        ];
        parent::__construct($data, $options);
    }
}