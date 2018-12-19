<?php

namespace app\widgets\currency;

use app\models\Currencies;
use core\base\Widget;

/**
 * Виджет управления валютой
 */
class Currency extends Widget{
    
     public function __construct() {
        parent::__construct('currency');
     }
     
     /**
      * Виртуальный метод. Исполнение виджета
      */
    protected function run() {
        $currencies = new Currencies();
        $currency = $currencies->current;

        $this->setData(compact('currencies', 'currency'));
        parent::run();
     }
     
}
