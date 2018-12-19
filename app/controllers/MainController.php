<?php

namespace app\controllers;

use app\models\Brands;
use app\models\Currencies;
use app\models\Products;
use core\base\Application;

/**
 * Контроллер по умолчанию
 */
class MainController extends AppController {
    
    public function __construct($route) {
        parent::__construct($route);
    }
    
    public function indexAction() {
        $config = Application::getConfig();
        $this->getView()->setMeta($config->site->shop_name, $config->site->description,$config->site->keywords);
        
        $brands = new Brands();
        $products = new Products();
        $currency = (new Currencies())->current;
        
        $this->getView()->setData(compact('brands', 'products', 'currency'));
    }
}
