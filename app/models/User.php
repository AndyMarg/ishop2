<?php

namespace app\models;


use core\base\ModelDb;

/**
 * @property string password
 * * @property int id
 */
class User extends ModelDb
{
    /**
     * Инициализируем пользователя из формы или БД
     * @param array|string $data Массив данных из формы или логин пользователя для запроса данных из БД
     * @throws \Exception
     */
    public function __construct($data)
    {
        $rules = [
            'required' => [['login'], ['password'], ['name'], ['email'], ['address']],
            'email' => [['email']],
            'lengthMin' => [['password',6]]
        ];

        $options = [
            'sql2' => "select * from user where login = :login",
            'params2' => [':login' => $data],
            'storage' => 'user',
            'table' => 'user',
            'insert_fields' => ['login', 'password', 'email', 'name', 'address'],
            'unique_fields' => ['login' => 'Имя пользователя уже занято', 'email' => 'Такой почтовый адрес уже есть']
        ];

        parent::__construct($data, $options, $rules);
    }

    /**
     * Сохранить пользователя в БД
     * @return bool
     */
    public function save()
    {
        $password = $this->data['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->data['password'] = $hash;
        return parent::save();
    }

    /**
     * Возвращает экземпляр класса из сессии (если есть) или создает новый и помещает в сессию
     * @param array|string|null $data Массив данных из формы или логин пользователя для запроса данных из БД
     * @return User|null instance
     * @throws \Exception
     */
    public static function get($data = null) {
        if (!isset($_SESSION['user'])) {
            if (!$data) return null;
            $instance = new User($data);
            $_SESSION['user'] = $instance;
        } else {
            $instance = $_SESSION['user'];
        }
        return $instance;
    }

    /**
     * Очищаем данные пользователя в сессии
     */
    public static function clear()
    {
        unset($_SESSION['user']);
    }

}