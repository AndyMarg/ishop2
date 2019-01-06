<?php

namespace app\models;


use core\base\ModelDb;

/**
 * @property mixed password
 */
class User extends ModelDb
{
    /**
     * User constructor.
     * @param $data
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
}