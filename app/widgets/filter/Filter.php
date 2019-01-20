<?php

namespace app\widgets\filter;


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
        $filter = new \app\models\Filter(2);

        $this->setData(compact('filter'));
        parent::run();
    }


}