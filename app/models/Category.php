<?php

namespace app\models;

use core\base\Application;

/**
 * Категория товара
 * @property int id
 */
class Category extends AppModel{

    public $child_ids = [];  // идентификаторы дочерних категорий

    /**
     * КОНСТРУКТОР
     * @param mixed $data Массив данных модели категории или ид модели категории для получения данных из БД
     * @throws \Exception
     */
    public function __construct($data) {
         $options = [
            'sql' => 'select * from category where id = :id',
            'params' => [':id' => $data['id']],
            'sql2' => "select * from category where alias = :alias",
            'params2' => [':alias' => $data],
            'storage' => "category_{$data['alias']}"
         ];
         parent::__construct($data, $options);
//        $this->getChildIds();
    }

    /**
     * Получить массив ид дочерних категорий
     */
    private function getChildIds() {
        $categories = Application::getStorage()->get('category');
        $id = $this->id;
        foreach ($categories as $category) {
            if ($category['parent_id'] = $id) {
                $this->child_ids[] = $category['id'];
                $this->getChildIds();
            }
        }
    }
}
