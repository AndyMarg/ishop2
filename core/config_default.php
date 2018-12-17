<?php

return
    [
        "mode" => "development",
        "dirs" => [
            "root" => "",
            "www" => "/public",
            "core" => "/core/base",
            "libs" => "/core/libs",
            "cache" => "/tmp/cache",
            "config" => "/config",
            "admin" => "/admin",
            "app" => "/app",
            "controllers" => "/app/controllers",
            "models" => "/app/models",
            "views" => "/app/views",
            "layouts" => "/app/views/layouts",
            "widgets" => "/app/widgets",
            "widget_controllers" => "/app/widgets/[widget]/controllers",
            "widget_tpls" => "/app/widgets/[widget]/tpl",
            "widget_scripts" => "/app/widgets/[widget]/js"
        ],
        "errors" => [
            "log" => "/logs/errors/errors.log",
            "pages" => [
                "page404" => "/public/errors/404.php",
                "page_common" => "/public/errors/common.html"
            ]
        ],
        "admin" => [
            "uri" => "admin"
        ],
        "defaults" => [
            "layout" => "default",
            "meta" => [
                "title" => "Интернет-магазин",
                "description" => "Интернет-магазин",
                "keywords" => "Интернет-магазин"
            ]
        ],
        "routes" => [
            "default" => [
                "base" => [
                    "regexp" => "^$",
                    "controller" => "Main",
                    "action" => "index"
                ],
                "dynamic" => [
                    "regexp" => "^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$",
                    "action" => "index"
                ]
            ]
        ],
        "db" => [
            "dsn" => "",
            "user" => "",
            "pass" => "",
            "debug" => false
        ],
        "widgets" => []
    ];
