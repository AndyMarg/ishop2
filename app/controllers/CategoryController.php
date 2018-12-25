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
        $products = new ProductsForCategory($category->id);
        $currency = (new Currencies())->current;

        $this->getView()->setMeta("Товары по категории:" . "\"{$category->title}\"", $category->description, $category->keywords);
        $this->getView()->setData(compact('products', 'currency', 'category'));
    }

}