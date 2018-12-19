<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Modification;
use app\models\Product;
use core\libs\Utils;

/**
 * Контроллер корзины
 */
class CartController extends AppController {
    
    /**
     * Добавляем товар в корзину
     */
    public function addAction() {
        if (!$this->isAjax()) {
            Utils::redirect();
        }
        // получаем ид товара, ид модификации товара, количество товара из запроса
        $product_id = (int) filter_input(INPUT_GET, 'id');
        $modifier_id = (int) filter_input(INPUT_GET, 'modifier');
        $quantity = (int) filter_input(INPUT_GET, 'quantity');
        // получаем товар из базы
        $product = new Product($product_id);
        if ($product->isEmpty()) {
            $this->errorAjax("Product not found");
        }
        // получаем модификацию товара из базы
        $modification = new Modification($modifier_id);
        if ($modification->isEmpty()) {
            $modification = null;
        }
        // добавляем товар в корзину
        $cart = Cart::getInstance();
        $cart->addProduct($product, $quantity, $modification);
//        print_r($cart->asArray()); die;
        
        $this->getView()->setData(compact('cart'));
    }

}
