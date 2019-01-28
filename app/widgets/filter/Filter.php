<?php

namespace app\widgets\filter;


use app\models\Filters;
use core\base\Widget;

class Filter extends Widget
{
    public function __construct() {
        $options = [
//            "cachePeriod" => "120"
        ];

        parent::__construct('filter', $options);
    }

    /**
     * Виртуальный метод. Исполнение виджета
     */
    protected function run() {
        $filter_get = filter_input(INPUT_GET, 'filter') ?: null;

        $filters = new Filters();
        $filter_active = ($filter_get ? explode(',', $filter_get) : []);

        $this->setData(compact('filters', 'filter_active'));
        parent::run();
    }


}