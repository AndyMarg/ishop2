<?php

namespace app\controllers;


use app\models\Currencies;
use app\models\ProductsSearched;
use core\base\Application;
use core\libs\Utils;
use SebastianBergmann\CodeCoverage\Util;

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

    /**
     * Выдать страницу результатов поиска
     */
    public function indexAction()
    {
        $search = Utils::htmlClear(filter_input(INPUT_GET, 'search_value'));
        if ($search) {
            $products = new ProductsSearched($search);
            $currency = (new Currencies())->current;
            $this->getView()->setMeta("Поиск по:" . "\"{$search}\"", "Результаты поиска", "результаты поиск");
            $this->getView()->setData(compact('products', 'currency', 'search'));
        }
    }
}