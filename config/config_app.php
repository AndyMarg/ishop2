<?php

return
    [
        "dirs" => [
            "root" => "/"
        ],
        "email" => [
            "admin" => "Andrey.Margashov@yandex.ru"
        ],
        "smtp" => [
            "login" => "",
            "password" => ""
        ],
        "site" => [
            "shop_name" => "Интернет-магазин чего-то там...",
            "description" => "Очень клевый магазинчик",
            "keywords" => "всякая фигня"
        ],
        "interface" => [
            "pagination" => [
                "rows_on_page" => 3
            ],
            "recently_viewed_count" => 3
        ],
        "routes" => [
            "user" => [
                "product" => [
                    "regexp" => "^product/(?P<alias>[a-z0-9-]+)/?$",
                    "controller" => "Product",
                    "action" => "view"
                ]
            ]
        ],
        "db" => [
            "dsn" => "mysql:host=localhost;dbname=ishop;charset=utf8",
            "user" => "marg",
            "pass" => "letmedoit",
            "debug" => true
        ],
        "defaults" => [
            "layout" => "watches"
        ],
        "widgets" => ["currency"]
    ];

