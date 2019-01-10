<?php


namespace app\controllers;


use app\models\Cart;
use app\models\user;
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
            $redirect = filter_input(INPUT_GET, 'redirect', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $user = User::get($data);
            if (!$user->validate()) {
                $_SESSION['errors'] = $user->getErrors();
                $_SESSION['form_data'] = $data;
                User::clear();
                Utils::redirect();
            } else {
                if ($user->save()) {
                    Cart::clear();
                    if ($redirect === 'root') {
                        Utils::redirect('/');
                    } else {
                        Utils::redirect();
                    }
                }
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
        $redirect = filter_input(INPUT_GET, 'redirect', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // если данные переданы из формы - пытаемся авторизовать пользователя,
        // иначе выводим форму для запроса данных
        if (!empty($_POST)) {
            $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//            $mode = filter_input(INPUT_GET, 'mode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($login && $password) {
                $user = user::get($login);
                if(!$user->isEmpty()) {
                    $hash = $user->password;
                    if (password_verify($password, $hash)) {
                        Cart::clear();
                        if ($redirect === 'root') {
                            Utils::redirect('/');
                        } else {
                            Utils::redirect();
                        }
                    } else {
                        $_SESSION['errors']['authority'][] = 'Логин/пароль введены неверно';
                        user::clear();
                    }
                } else {
                    $_SESSION['errors']['authority'][] = 'Логин/пароль введены неверно';
                    user::clear();
                }
            }
            Utils::redirect();
        } else {
            $this->getView()->setMeta("Авторизация");
        }
    }

    public function logoutAction()
    {
        User::clear();
        Cart::clear();
        Utils::redirect();
    }
}