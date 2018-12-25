<?php

namespace app\models;

/**
 * Категория товара
 * @property int id
 * @property string title
 * @property string description
 * @property string keywords
 */
class Category extends AppModel {

    /**
     * КОНСТРУКТОР
     * @param mixed $data Массив данных модели категории или ид модели категории для получения данных из БД
     * @throws \Exception
     */
    public function __construct($data) {
        if (gettype($data) === 'array') {
            $options = ["storage" => "category_{$data['id']}"];
        } else {
            $options = [
                'sql' => 'select * from category where id = :id',
                'params' => [':id' => $data],
                'sql2' => "select * from category where alias = :alias",
                'params2' => [':alias' => $data],
                'storage' => "category_{$data}"
            ];
        };
        parent::__construct($data, $options);
    }

    /**
     * Получить массив ид дочерних категорий
     */
    public function getChildsIds()
    {
        $categories = (new Categories())->asArray();
        $ids = [$this->id];
        $this->fillChildIdsRecursive($this->id, $categories, $ids);
        return $ids;
    }

    /**
     * Рекурсивно заполняет массив идентификаторами дочерних категорий
     * @param int $parent_id Ид родительской категории
     * @param array $categories Массив всех категорий
     * @param array $ids Массив идентификаторов дочерних категорий (передается по ссылке)
     */
    private function fillChildIdsRecursive($parent_id, $categories, &$ids) {
        foreach ($categories as $category) {
            if ($category['parent_id'] === $parent_id) {
                $ids[] = $category['id'];
                $this->fillChildIdsRecursive($category['id'], $categories, $ids);
            }
        }
    }
}
