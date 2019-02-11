<?php

namespace app\controllers\admin;


use app\models\Categories;
use app\models\Category;
use core\libs\Utils;

class CategoryController extends AdminController
{

    public function indexAction()
    {
        $categories = new Categories();

        $this->getView()->setMeta("Список категорий");
        $this->getView()->setData(compact('categories'));
    }


    /**
     * @throws \Exception
     */
    public function deleteAction()
    {
        $id = (int) filter_input(INPUT_GET, 'id');

        if (!$id) {
            throw new \Exception("Category not found");
        }
        $category = new Category($id);
        if ($category->cnt_prod > 0) {
            $_SESSION['errors']['category'][] = 'В данной категории имеются товары. Удаление невозможно';
        }
        if ($category->cnt_subcategory > 0) {
            $_SESSION['errors']['category'][] = 'В данной категории имеются подкатегории. Удаление невозможно';
        }

        $category->delete();

        Utils::redirect('/admin/category');
    }
}