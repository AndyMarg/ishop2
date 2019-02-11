<?php


namespace app\models;

use core\base\ModelListDb;

/**
 * Список категорий товаров
 */
class Categories extends ModelListDb {

    private $flat_tree = [];

    public function __construct() {

        $sql = <<<SQL
select c.*, ifnull(t1.cnt, 0) cnt_prod, ifnull(t2.cnt, 0) cnt_subcategory
from category c
    left join (select category_id, count(*) cnt from product group by category_id) t1 on c.id = t1.category_id
    left join (select parent_id category_id, count(*) cnt from category group by parent_id) t2 on c.id = t2.category_id
SQL;

        $options = [
            'sql'  => $sql,
            'class' => 'Category',
            'storage' => 'categories'
        ];
        parent::__construct($options);
        $this->fillFlatTree($this->getTree(), 0);
    }

    /**
     * Раскладывает категории в виде дерева (вложенная категория в виде массива)
     * @return array Дерево категорий
     */
    private function getTree() : array
    {
        $tree = [];
        $data = $this->asArray(true);
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    /**
     * Раскладывает категории в "плоское" дерево (дочерние категории по родительскими на одном уровне)
     * @param array $node Текущий узел дерева категорий
     * @param int $level Текущий уровень вложенности
     */
    private function fillFlatTree(array $node, int $level) : void
    {
        foreach ($node as $id => $category) {
            $category['level'] = $level;
            $this->flat_tree[$id] = $category;
            if (key_exists('childs', $category)) {
                $this->fillFlatTree($category['childs'], $level+1);
            }
        }
    }

    /**
     * Возвращает "плоское" дерево категорий
     * @return array
     */
    public function getFlatTree() : array
    {
        return $this->flat_tree;
    }

}
