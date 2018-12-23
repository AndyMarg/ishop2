<?php

namespace app\controllers;


use core\base\Application;

class SearchController extends AppController {


    /**
     * "Живой поиск" товара
     */
    public function livesearchAction()
    {
        $search_string = filter_input(INPUT_GET, 'query');
        if ($this->isAjax()) {
            $result = Application::getDb()->query('select id, title from product where title like :title limit 10 ',
                [':title' => "%{$search_string}%"]);
            echo json_encode($result);
            die;
        }
    }
}