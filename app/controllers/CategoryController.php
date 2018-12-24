<?php

namespace app\controllers;


use app\models\Category;

class CategoryController extends AppController
{

    public function viewAction()
    {
        $category = new Category($this->getRoute()['alias']);

    }

}