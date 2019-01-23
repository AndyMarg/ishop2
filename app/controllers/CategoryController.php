<?php

namespace app\controllers;


use app\models\Category;
use app\models\Currencies;
use app\models\ProductsForCategory;

class CategoryController extends AppController
{

    public function viewAction()
    {
        $category = new Category($this->getRoute()['alias']);

        $page = (int) filter_input(INPUT_GET, 'page') ?: 1;
        $products = new ProductsForCategory($category->id, $page);
        $currency = (new Currencies())->current;

        if (!empty($_GET['filter'])) {
            $filters = $_GET['filter'];
        }

        if ($this->isAjax()) {
            var_dump($filters);
            die;
        }

        $this->getView()->setMeta("Товары по категории:" . "\"{$category->title}\"", $category->description, $category->keywords);
        $this->getView()->setData(compact('products', 'currency', 'category'));
    }

}