<?php

use core\base\Application;
use core\libs\Utils;

// автозагрузчик классов от composer
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Инициализирум приложение. Передаем корневой каталог приложения и json c настройками конфигурации
Application::Init(Utils::getRoot(), '/config/config_app.php');

