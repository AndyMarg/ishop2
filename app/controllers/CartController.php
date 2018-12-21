<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Currencies;
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

        // текущая валюта
        $currency = (new Currencies())->current;

        $this->getView()->setData(compact('cart', 'currency'));
    }

    /**
     * Получить корзину
     */
    public function showAction() {
        if (!$this->isAjax()) {
            Utils::redirect();
        }
        $cart = Cart::getInstance();
        $currency = (new Currencies())->current;
        $this->getView()->setData(compact('cart', 'currency'));
    }

    /**
     * Удалить товар из корзины
     */
    public function deleteAction()
    {
        if (!$this->isAjax()) {
            Utils::redirect();
        }
        $product_id = (int) filter_input(INPUT_GET, 'id');
        $cart = Cart::getInstance();
        $products = $cart->products;
        $delta = $products[$product_id]['price'] * $products[$product_id]['quantity'];
        $cart->sum -= $delta;
        $cart->quantity -= $products[$product_id]['quantity'];
        unset($products[$product_id]);
        $cart->products = $products;
        $currency = (new Currencies())->current;
        $this->getView()->setData(compact('cart', 'currency'));
    }

    /**
     * Очистить корзину
     */
    public function clearAction()
    {
        if (!$this->isAjax()) {
            Utils::redirect();
        }
        $cart = Cart::getInstance();
        $cart->products = [];
        $cart->sum = 0;
        $cart->quantity = 0;
        $currency = (new Currencies())->current;
        $this->getView()->setData(compact('cart', 'currency'));
    }
}
