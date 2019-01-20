<?php

namespace app\models;


use core\base\ModelDb;

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
            'sql' => "select g.title filter_name, g.id filter__id, v.id, v.value " .
                     "from attribute_group g join attribute_value v on v.attr_group_id = g.id where g.id = :id;",
            'params' => [':id' => $id],
            'fetch_mode' => \PDO::FETCH_GROUP
        ];
        parent::__construct($data, $options);
        var_dump($this->data);
    }
}