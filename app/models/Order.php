<?php

namespace app\models;


use core\base\Application;
use core\base\ModelDb;
use core\libs\Utils;
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
    public function __construct($data, User $user = null, Cart $cart = null)
    {
        $this->cart = $cart;
        
        $this->user = $user;

        if (gettype($data) === 'array' && $this->user) {
            $data['user_id'] = $this->user->id;
        }

        $sql = <<<SQL
select o.*, round(c.summa*r.value,2) summa, c.cnt, o.currency currency_code, u.name user
from `order` o
       join `user` u on u.id = o.user_id
       join currency r on r.code = o.currency
       join (select order_id, sum(qty * price) summa, count(*) cnt from order_product group by order_id) c on c.order_id = o.id
where o.id = :id
SQL;

        $options = [
            'sql' => $sql,
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
        $site = Application::getConfig()->site;

        $transport = (new Swift_SmtpTransport($smtp->host, $smtp->port))
            ->setUsername($smtp->login)
            ->setPassword($smtp->password);

        $mailer = new Swift_Mailer($transport);

        ob_start();
        $cart = $this->cart;
        $currency = (new Currencies())->current;
        require Utils::getRoot() . Application::getConfig()->dirs->views . '/mail/mail_order.php';
        $body = ob_get_clean();

        $message = (new Swift_Message("Вы совершили заказ №{$this->id} на сайте \"{$site->shop_name}\""))
            ->setFrom([$site->email => $site->shop_name])
            ->setTo([ $this->user->email => $this->user->name])
            ->setBody($body, 'text/html');
        ;
        $result = $mailer->send($message);
    }


}