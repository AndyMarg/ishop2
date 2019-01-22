<?php

namespace app\widgets\filter;


use app\models\Filters;
use core\base\Widget;

class Filter extends Widget
{
    public function __construct() {
        $options = [
            "cachePeriod" => "120"
        ];

        parent::__construct('filter', $options);
    }

    /**
     * Виртуальный метод. Исполнение виджета
     */
    protected function run() {
        $filters = new Filters();

        $this->setData(compact('filters'));
        parent::run();
    }


}