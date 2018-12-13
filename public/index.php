<?php

use core\libs\Utils;

// автозагрузчик классов от composer
require_once dirname(__DIR__) . '/vendor/autoload.php';

var_dump(Utils::getRoot());
