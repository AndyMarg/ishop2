<?php
/**
 * Created by PhpStorm.
 * User: Andrey.Margashov
 * Date: 09.01.2019
 * Time: 11:18
 */

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
        $cart = Cart::getInstance();
        $currency = (new Currencies())->current;
        $user = User::get();

        $data['user_id'] = $user->id;
        $data['currency'] = $currency->code;
        $data['note'] = $note;
        $order = new Order($data);
        $order->save();

        $this->getView()->setMeta('Заказ оформлен');
        $this->getView()->setData(compact('cart', 'currency', 'order'));
    }

    /**
     * Показать данные заказа
     * @throws \Exception
     */
    public function showAction()
    {
        $cart = Cart::getInstance();
        $currency = (new Currencies())->current;
        $this->getView()->setMeta('Заказ товара');
        $this->getView()->setData(compact('cart', 'currency'));
    }
}