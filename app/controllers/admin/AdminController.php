<?php

namespace app\controllers\admin;


use app\models\User;
use core\base\Application;
use core\base\Controller;
use core\libs\Utils;

class AdminController extends Controller
{

    public function __construct($route)
    {
        parent::__construct($route);

        $user = User::get();

        if (!$user || !$user->isAdmin()) {
            if ($route['action'] != 'login') {
                Utils::redirect(Application::getConfig()->dirs->admin . '/user/login');
            }
        }
    }


}