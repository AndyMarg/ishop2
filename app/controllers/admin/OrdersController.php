<?php

namespace app\controllers\admin;


use app\models\Orders;

class OrdersController extends AdminController
{

    public function indexAction()
    {
        $page = (int) filter_input(INPUT_GET, 'page') ?: 1;

        $orders = new Orders($page);

        $this->getView()->setData(compact('orders'));
        $this->getView()->setMeta("Список заказов");
    }
}