<?php

namespace app\models;


use core\base\Application;
use core\base\ModelDb;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

/**
 * @property mixed id
 */
class Order extends ModelDb
{
    private $user;
    private $cart;

    /**
     * Инициализируем заказ из формы или БД
     * @param array|int $data Массив данных из формы или id заказа для запроса данных из БД
     * @param User $user Пользователь
     * @param Cart $cart Корзина
     * @throws \Exception
     */
    public function __construct($data, User $user, Cart $cart)
    {
        $this->cart = $cart;
        
        $this->user = $user;
        if (gettype($data) === 'array') {
            $data['user_id'] = $this->user->id;
        }

        $options = [
            'sql' => "select * from user where id = :id",
            'params' => [':id' => $data],
            'storage' => 'order',
            'table' => "`order`",
            'insert_fields' => ['user_id', 'currency', 'note']
        ];

        parent::__construct($data, $options);
    }

    /**
     * Сохраняем заказ в БД
     * @return bool|void
     * @throws \Exception
     */
    public function save()
    {
        $result = parent::save();
        if ($result) {
            foreach ($this->cart->products as $product) {
                $data['order_id'] = $this->id;
                $data['product_id'] = $product['product_id'];
                $data['qty'] = $product['quantity'];
                $data['title'] = $product['title'];
                $data['price'] = $product['price'];
                $order_item = new OrderItem($data);
                $result = $order_item->save();
            }
        }
        return $result;
    }

    /**
     * Отправляет заказ на электронную почту пользователя
     */
    public function mail()
    {
        $smtp = Application::getConfig()->smtp;

        $transport = (new Swift_SmtpTransport($smtp->host, $smtp->port))->setUsername($smtp->login)->setPassword($smtp->password);

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Your order registered!'))
            ->setFrom(['ishop@best.com' => ''])
            ->setTo([$smtp->receiver => 'Customer'])
            ->setBody('Order registered!')
        ;
        $result = $mailer->send($message);
    }


}