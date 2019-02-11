<?php

namespace app\models;

/**
 * Категория товара
 * @property int id
 * @property string title
 * @property string description
 * @property string keywords
 * @property int category_id
 * @property int cnt_prod
 * @property int cnt_subcategory
 */
class Category extends AppModel {

    /**
     * КОНСТРУКТОР
     * @param mixed $data Массив данных модели категории или ид модели категории для получения данных из БД
     * @throws \Exception
     */
    public function __construct($data) {

        $sql = <<<SQL
select c.*, ifnull(t1.cnt, 0) cnt_prod, ifnull(t2.cnt, 0) cnt_subcategory
from category c
    left join (select category_id, count(*) cnt from product group by category_id) t1 on c.id = t1.category_id
    left join (select parent_id category_id, count(*) cnt from category group by parent_id) t2 on c.id = t2.category_id
where c.id = :id
SQL;


        if (gettype($data) === 'array') {
            $options = ["storage" => "category_{$data['id']}"];
        } else {
            $options = [
                'sql' => $sql,
                'params' => [':id' => $data],
                'sql2' => "select * from category where alias = :alias",
                'params2' => [':alias' => $data],
                'storage' => "category_{$data}",
                'table' => 'category'
            ];
        };
        parent::__construct($data, $options);
    }

    /**
     * Возвращает массив объектов категории для представления  в виде "хлебных крошек"
     * @return array
     * @throws \Exception
     */
    public function getBreadcrumbs() {
        $categories = new Categories();
        $category = $categories->search('id', $this->id);
        do {
            $result[] = $category;
            $parent_id = $category->parent_id;
            $category = $categories->search('id', $parent_id);
        } while ((int)$parent_id != 0);
        return array_reverse($result);
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
