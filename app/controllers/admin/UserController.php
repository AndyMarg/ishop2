<?php

namespace app\controllers\admin;


use app\models\User;
use core\base\Application;
use core\libs\Utils;

class UserController extends AdminController
{

    public function loginAction()
    {
        if (!empty($_POST)) {
            $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($login && $password) {
                $user = User::get($login);
                if (!$user->isEmpty()) {
                    $hash = $user->password;
                    if (password_verify($password, $hash) && $user->isAdmin()) {
                        Utils::redirect(Application::getConfig()->dirs->admin);
                    } else {
                        $_SESSION['errors']['authority'] = 'Логин/пароль введены неверно';
                        user::clear();
                    }
                } else {
                    $_SESSION['errors']['authority'] = 'Логин/пароль введены неверно';
                    user::clear();
                }
            }
            Utils::redirect();
        } else {
            $this->getView()->setLayout('login');
            $this->getView()->setMeta("Вход/Регистрация");
        }

    }

}