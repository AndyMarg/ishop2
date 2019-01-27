<?php

namespace app\controllers;


use app\models\Category;
use app\models\Currencies;
use app\models\ProductsFiltered;
use app\models\ProductsForCategory;
use core\base\View;

class CategoryController extends AppController
{

    public function viewAction()
    {
        $category = new Category($this->getRoute()['alias']);

        $page = (int) filter_input(INPUT_GET, 'page') ?: 1;
        $filters = filter_input(INPUT_GET, 'filter') ?: null;

        $currency = (new Currencies())->current;

        if ($filters) {
            $filter_ids = explode(',', $filters);
            $products = new ProductsFiltered($category->id, $filter_ids, $page);
        } else {
            $products = new ProductsForCategory($category->id, $page);
        }

        // если запрос ajax и запрошена фильтрация товаров
        if ($this->isAjax()) {
            $num_in_row = 3;
            echo View::fragment('products',compact(['products', 'currency', 'num_in_row']));
            die;
        }

        $this->getView()->setMeta("Товары по категории:" . "\"{$category->title}\"", $category->description, $category->keywords);
        $this->getView()->setData(compact('products', 'currency', 'category'));
    }

}