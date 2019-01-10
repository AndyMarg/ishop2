<?php

namespace app\controllers;


use app\models\Cart;
use app\models\Currencies;
use app\models\Order;
use app\models\User;

class OrderController extends AppController
{

    /**
     * Добавить заказ
     */
    public function addAction()
    {
        $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $currency = (new Currencies())->current;
        $cart = Cart::get();
        $user = User::get();

        $data['currency'] = $currency->code;
        $data['note'] = $note;
        $order = new Order($data, $user, $cart);

        if ($order->save()) {
            $order->mail();
        };

        $this->getView()->setMeta('Заказ оформлен');
        $this->getView()->setData(compact('cart', 'currency', 'order'));
    }

    /**
     * Показать данные заказа
     * @throws \Exception
     */
    public function showAction()
    {
        $cart = Cart::get();
        $currency = (new Currencies())->current;
        $this->getView()->setMeta('Заказ товара');
        $this->getView()->setData(compact('cart', 'currency'));
    }
}