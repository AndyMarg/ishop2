<?php

namespace app\controllers\admin;


use core\base\Application;

class MainController extends AdminController
{

    public function indexAction()
    {
        $cnt_new_order = (int)(Application::getDb()->query("select count(*) cnt from `order` where status = '0'")[0]['cnt']);
        $cnt_user = (int)(Application::getDb()->query("select count(*) cnt from `user`")[0]['cnt']);
        $cnt_product = (int)(Application::getDb()->query("select count(*) cnt from `product`")[0]['cnt']);
        $cnt_category = (int)(Application::getDb()->query("select count(*) cnt from `category`")[0]['cnt']);
        $this->getView()->setMeta("Панель администрирования");
        $this->getView()->setData(compact('cnt_new_order', 'cnt_user', 'cnt_product', 'cnt_category'));
    }
}