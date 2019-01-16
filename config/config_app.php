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
            "host" => "smtp.mailtrap.io",
            "port" => "2525",
            "protocol" => "ssl",
            "login" => "588ab5eff266c4",
            "password" => "39136a43bff979",
            "receiver" => "test-4d819a@inbox.mailtrap.io"
        ],
        "site" => [
            "shop_name" => "Интернет-магазин чего-то там...",
            "description" => "Очень клевый магазинчик",
            "keywords" => "всякая фигня",
            "email" => "ishop@best.com"
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
                ],
                "category" => [
                    "regexp" => "^category/(?P<alias>[a-z0-9-]+)/?$",
                    "controller" => "Category",
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

