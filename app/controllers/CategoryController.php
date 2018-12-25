<?php

namespace app\controllers;


use app\models\Category;
use app\models\Currencies;
use app\models\ProductsForCategory;
use core\base\Application;
use core\libs\Pagination;

class CategoryController extends AppController
{

    public function viewAction()
    {
        $category = new Category($this->getRoute()['alias']);
        $products = new ProductsForCategory($category->id);
        $currency = (new Currencies())->current;

        $page = (int) filter_input(INPUT_GET, 'page');
        $countOnPage = Application::getConfig()->interface->pagination->rows_on_page;
        $total = $products->count();
        $pagination = new Pagination($page, $countOnPage, $total);

        $this->getView()->setMeta("Товары по категории:" . "\"{$category->title}\"", $category->description, $category->keywords);
        $this->getView()->setData(compact('products', 'currency', 'category'));
    }

}