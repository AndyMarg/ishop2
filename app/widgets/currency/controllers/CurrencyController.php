<?php

namespace app\widgets\currency\controllers;

use app\controllers\AppController;
use core\libs\Utils;

/**
 * Обработчик переключения валют
 */
class CurrencyController extends AppController {
    
    /**
     * Записываем куку с выбранной валютой и редиректим на главную страницу
     */
    public function changeAction() {
        $currency =  filter_input(INPUT_GET, 'currency');
        if (!empty($currency)) {
            setcookie('currency', $currency, time() + 3600*24*7, '/');
        }
        Utils::redirect();
    }
    
}
