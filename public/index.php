<?php

use core\base\Config;
use core\libs\Utils;

// автозагрузчик классов от composer
require_once dirname(__DIR__) . '/vendor/autoload.php';

$config = Config::getInstance();
$config->Init(Utils::getRoot(), '/config/config_app.php');

var_dump($config->mode);

