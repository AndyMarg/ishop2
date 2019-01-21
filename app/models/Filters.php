<?php

namespace app\models;


use core\base\ModelListDb;

/**
 * Class Filters Все фильтры
 * @package app\models
 */
class Filters extends ModelListDb
{
    public function __construct() {
        $options = [
            'sql'  => "select v.id, v.value, g.title filter_name, g.id filter_id " .
                      "from attribute_group g join attribute_value v on v.attr_group_id = g.id;",
            'class' => 'Filter'
        ];
        parent::__construct($options);
    }

    /**
     * @return array Список групп фильтров
     */
    public function getFilterGroups()
    {
        $result = [];
        foreach ($this as $filter) {
            if (!key_exists($filter->filter_id, $result)) {
                $result[$filter->filter_id] = $filter->filter_name;
            }
        }
        return $result;
    }

    /**
     * @param int $filter_id ИД группы фильтра
     * @return array Массив значений группы фильтра
     */
    public function getFilterGroup(int $filter_id)
    {
        $result = [];
        foreach ($this as $filter) {
            if ($filter->filter_id == $filter_id) {
                $result[] = $filter;
            }
        }
        return $result;
    }
}