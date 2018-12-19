<?php

namespace app\models;

use core\base\ModelListDb;

/**
 * Список просмотренных товаров
 */
class ProductsViewed extends ModelListDb {
    
    public function __construct(int $id) {
        $ids = self::getRecentlyViewed();
        // берем последние "recently_viewed_count" товаров
        $ids = array_slice($ids, -(\core\base\Application::getConfig()->interface->recently_viewed_count));
        $options = [
            'sql'  => "select * from product where id in (:ids)",
            'params' => [":ids" => $ids],
            'class' => 'Product',
            'storage' => 'productsViewed'
        ];
        parent::__construct($options);
    }
    
    /**
     * Возвращает массив идентификаторов последних просмотренныых товаров из куки
     * @return type
     */
    public static function getRecentlyViewed() {
        $cookie_value = filter_input(INPUT_COOKIE, 'recentlyViewed') ?? false;
        $temp = $cookie_value ? explode(',', $cookie_value) : [];
        $result = [];    
        foreach ($temp as $id) {
            $result[] = (int)$id;
        }
        return $result;
    }
    
    /**
     * Сохраняет массив последних просмотренных товаров в куки
     */
    public static function setRecentlyViewed(int $id) {
        $ids = self::getRecentlyViewed();
        // удаляем ид текущего товара
        $ids = array_diff($ids, [$id]);
        // добавляем ид текущего товара в конец списка
        $ids[] = $id;
        setcookie('recentlyViewed', implode(',', $ids), time() + 3600*24*7, '/');
    }

}
