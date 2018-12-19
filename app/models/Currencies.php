<?php

namespace app\models;

use core\base\ModelListDb;

/**
 * Список валют
 */
class Currencies extends ModelListDb {
    
    public function __construct() {
        $options = [
            'sql'  => "select * from currency",
            'class' => 'Currency',
            'storage' => 'currencies'
        ];
        parent::__construct($options);
    }
    
    /**
     * Текущая валюта
     * @return object
     */
    public function getCurrent() {
        $current_code = Currency::getCurrentCode();
        return ($current_code) ? $this->search('code', $current_code) : $this->at(0);
    }
}
