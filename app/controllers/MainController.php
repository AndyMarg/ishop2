<?php

namespace app\controllers;

use app\models\Brands;
use app\models\Currencies;
use app\models\Product;
use app\models\Products;
use core\base\Application;
use core\base\View;

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

        $page = (int) filter_input(INPUT_GET, 'page') ?: 1;

        $brands = new Brands();
        $products = new Products($page);
        $currency = (new Currencies())->current;

        $this->getView()->setData(compact('brands', 'products', 'currency'));
    }
}
