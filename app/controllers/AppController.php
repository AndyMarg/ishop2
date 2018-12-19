<?php

namespace app\controllers;

use core\base\Controller;

/**
 * Базовый контроллер приложения
 */
class AppController extends Controller {
    
    public function __construct($route) {
        parent::__construct($route);
    }
}
