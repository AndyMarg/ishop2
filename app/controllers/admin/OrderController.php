<?php

namespace app\controllers\admin;


use app\models\Order;
use app\models\OrderItems;

class OrderController extends  AdminController
{

    public function viewAction()
    {
        $id = (int) filter_input(INPUT_GET, 'id');

        $order = new Order($id);
        $order_items = new OrderItems($id);

        $this->getView()->setData(compact('order', 'order_items'));
        $this->getView()->setMeta("Информация о заказе");
    }

}