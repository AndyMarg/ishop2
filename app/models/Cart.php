<?php

namespace app\models;

use core\base\Model;

/**
 * Корзина
 * А-ля синглетон. Уникальный экземпляр, размещается в сессии
 * @property object products
 * @property float|int sum
 * @property int quantity
 */
class Cart extends Model {

    /**
     * Cart constructor.
     */
    private function __construct() {
        $data['products'] = [];
        $data['quantity'] = 0;
        $data['sum'] = 0;
        parent::__construct($data);
    }
    
    /**
     * Добавить товар в корзину
     * @param \app\models\Product $product
     * @param int $quantity
     * @param \app\models\Modification $modification
     */
    public function addProduct(Product $product, int $quantity, Modification $modification = null) {
        if ($modification) {
            $id = "{$product->id}-{$modification->id}";
            $temp['title'] = "{$product->title} ({$modification->title})";
            $temp['price'] = $modification->price;
        } else {
            $id = $product->id;
            $temp['title'] = $product->title;
            $temp['price'] = $product->price;
        }
        $temp['alias'] = $product->alias;
        $temp['quantity'] = $quantity;
        $temp['img'] = $product->img;
        
        $products = $this->products;
        if (array_key_exists($id, $products)) {
            $products[$id]['quantity'] += $quantity;
        } else {
            $products[$id] = $temp;
        }    
        $this->products = $products;
        
        $sum = 0; $qty = 0;
        foreach ($products as $product) {
            $sum += ($product['price'] * $product['quantity']);
            $qty +=  $product['quantity'];
            
        }
        $this->sum = $sum;
        $this->quantity = $qty;        
    }
    
    /**
     * Возвращает экземпляр класса из сессии (если есть) или создает новый и помещает в сессию
     * @return Cart instance
     */
    public static function getInstance() {
        if (!isset($_SESSION['cart'])) {
            $instance = new static;
            $_SESSION['cart'] = $instance;
        } else {
            $instance = $_SESSION['cart'];
        }
        return $instance;
    }
    
}
