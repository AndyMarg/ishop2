<?php

namespace app\controllers\admin;


use app\models\Categories;
use app\models\Category;
use core\base\Application;
use core\libs\Utils;

class CategoryController extends AdminController
{

    /**
     * Show categories list
     * @throws \Exception
     */
    public function indexAction()
    {
        $categories = new Categories();

        $this->getView()->setMeta("Список категорий");
        $this->getView()->setData(compact('categories'));
    }


    /**
     * Delete category
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

    /**
     * Add category
     * @throws \Exception
     */
    public function addAction()
    {
        if (!empty($_POST)) {
            $data['title'] = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['parent_id'] = (int)filter_input(INPUT_POST, 'parent_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['keywords'] = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['description'] = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['alias'] = 'alias';

            $category = new Category($data);
            if (!$category->validate()) {
                $_SESSION['errors'] = $category->getErrors();
                $_SESSION['form_data'] = $data;
                Utils::redirect();
            } else {
                if ($category->save()) {
                    Utils::redirect(Application::getConfig()->dirs->admin . '/category');
                }
            }
        } else {
            $categories = new Categories();
             $this->getView()->setMeta('Новая категория');
            $this->getView()->setData(compact('categories'));
        }
    }

}