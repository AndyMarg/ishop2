<?php

namespace app\widgets\filter;


use app\models\Filters;
use core\base\Widget;

class Filter extends Widget
{
    public function __construct() {
        parent::__construct('filter', []);
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