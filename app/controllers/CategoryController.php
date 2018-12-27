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

        $page = (int) filter_input(INPUT_GET, 'page') ?: 1;
        $countOnPage = Application::getConfig()->interface->pagination->rows_on_page;
        $total = (new ProductsForCategory($category->id))->getCountRecords();
        $pagination = new Pagination($page, $countOnPage, $total);
        $start = $pagination->getStartRecord();

        $products = new ProductsForCategory($category->id, $start, $countOnPage);
        $currency = (new Currencies())->current;

        $this->getView()->setMeta("Товары по категории:" . "\"{$category->title}\"", $category->description, $category->keywords);
        $this->getView()->setData(compact('products', 'currency', 'category', 'pagination'));
    }

}