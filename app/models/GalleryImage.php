<?php

namespace app\models;

/**
 * Рисунок галереи
 */
class GalleryImage extends AppModel {

    /**
     * КОНСТРУКТОР
     * @param mixed $data Массив данных модели рисунка или ид модели рисунка для получения данных из БД
     * @throws \Exception
     */
    public function __construct($data) {
        $id = gettype($data) === 'integer' ? $data : NULL;
         $options = [
            'sql' => 'select * from gallery where id = :id',
            'params' => [':id' => $id]
        ];
        parent::__construct($data, $options);
    }
    
}
