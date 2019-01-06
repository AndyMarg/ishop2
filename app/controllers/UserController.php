<?php


namespace app\controllers;


use app\models\User;
use core\libs\Utils;

class UserController extends AppController
{

    /**
     * Регистрация нового пользователя.
     */
    public function signupAction()
    {
        // если данные переданы из формы - пытаемся создать пользователя,
        // иначе выводим форму для запроса данных
        if (!empty($_POST)) {
            $data['login'] = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['address'] = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $user = new User($data);
            if (!$user->validate()) {
                $_SESSION['errors'] = $user->getErrors();
                $_SESSION['form_data']= $data;
                Utils::redirect();
            } else {
                $user->save();
                $_SESSION['success'] = 'Пользователь зарегистрирован';
                Utils::redirect();
            }
       } else {
            $this->getView()->setMeta("Регистрация");
        }
    }

    /**
     * Авторизация пользователя
     * @throws \Exception
     */
    public function loginAction()
    {
        // если данные переданы из формы - пытаемся авторизовать пользователя,
        // иначе выводим форму для запроса данных
        if (!empty($_POST)) {
            $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $mode = filter_input(INPUT_GET, 'mode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($login && $password) {
                $user = new User($login);
                if(!$user->isEmpty()) {
                    $hash = $user->password;
                    if (password_verify($password, $hash)) {
                        $data = $user->asArray();
                        unset($data['password']);
                        $_SESSION['user'] = $data;
                        Utils::redirect('/');
                    } else {
                        $_SESSION['errors']['authority'][] = 'Логин/пароль введены неверно';
                        unset($_SESSION['user']);
                    }
                } else {
                    $_SESSION['errors']['authority'][] = 'Логин/пароль введены неверно';
                    unset($_SESSION['user']);
                }
            }
            Utils::redirect();
        } else {
            $this->getView()->setMeta("Авторизация");
        }
    }

    public function logoutAction()
    {
        unset($_SESSION['user']);
        Utils::redirect();
    }
}