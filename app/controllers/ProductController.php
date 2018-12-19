<?php

namespace app\controllers;

use app\models\Currencies;
use app\models\Product;
use app\models\ProductsViewed;
use Exception;

/**
 * Контроллер для обработки запросов о продукте
 */
class ProductController extends AppController {
    
    public function __construct($route) {
        parent::__construct($route);
    }
    
    public function viewAction() {
        $name = $this->getRoute()['alias'];

        // запрошенный товар
        $product = new Product($name);
        if (!$product) {
            throw  new Exception("Страница не найдена", 404);
        }
        
        // сохраняем ид просмотренного товара в куке
        ProductsViewed::setRecentlyViewed($product->id);
        
        // текущая валюта
        $currency = (new Currencies())->current;

        $this->getView()->setMeta($product->title, $product->description, $product->keywords);
        $this->getView()->setData(compact('product', 'currency'));
    }
    
    
}
