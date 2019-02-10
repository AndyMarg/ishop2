<?php

namespace app\controllers\admin;


use app\models\Order;
use app\models\OrderItems;
use core\libs\Utils;

class OrderController extends  AdminController
{

    /**
     * Просмотр заказа
     * @throws \Exception
     */
    public function viewAction()
    {
        $id = (int) filter_input(INPUT_GET, 'id');

        $order = new Order($id);
        $order_items = new OrderItems($id);

        $this->getView()->setData(compact('order', 'order_items'));
        $this->getView()->setMeta("Информация о заказе");
    }

    /**
     * Изменить статус заказа
     * @throws \Exception
     */
    public function changeAction()
    {
        $id = (int) filter_input(INPUT_GET, 'id');
        $status = filter_input(INPUT_GET, 'status');

        $order = new Order($id);

        if (!$order) {
            throw new \Exception("Order not found");
        }

        $order->status = ($order->status == '0') ? '1' : '0';
        $order->update_at = date('Y-m-d H:i:s');
        $order->save();
        Utils::redirect();
    }

    /**
     * Удалить заказ
     * @throws \Exception
     */
    public function deleteAction()
    {
        $id = (int) filter_input(INPUT_GET, 'id');
        if (!$id) {
            throw new \Exception("Order not found");
        }
        $order = new Order($id);
        $order->delete();
        Utils::redirect('/admin/orders');
    }
}


