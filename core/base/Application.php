<?php

namespace core\base;

/**
 * Класс приложения.
 * Только статические методы.
 */
class Application {
    
//    private static $router;
    private static $db;

    /**
     * Вернуть URL корня приложения
     * @return string
     */
    public static function getRootURL() {
        return 'http://' . filter_input(INPUT_SERVER, 'SERVER_NAME');
    }

    /**
     * Вернуть объект конфигурации приложения
     * 
     * @return object
     */
    public static function getConfig() {
        return Config::getInstance();
    }
    
    /**
     * Вернуть объект хранилища
     * @return object
     */
    public static function getStorage() {
        return Storage::getInstance();
    }
    
    /**
     * Вернуть объект менеджера БД
     * @return Db
     */
    public static function getDb() {
        return self::$db;
    }

//    /**
//     * Вернуть объект роутера
//     * @return type object Router
//     */
//    public static function getRouter() {
//        return self::$router;
//    }

    /**
     * Инициализирует приложение.
     *
     * @param string $app_root Корень приложения в файловой системе
     * @param string $app_config_file Файл с конфигурационными параметрами.
     */
    public static function Init(string $app_root, string $app_config_file = "") 
    {
        // создаем объект конфигурации
        $config = Config::getInstance();
        $config->Init($app_root, $app_config_file);
        
        // инициализируем обработчик ошибок
        new ErrorHandler();

        // стартуем сессию
        session_start();

        // подключаемся к базе
        self::$db = Db::getInstance();
        self::$db->Init();

//        // инициализируем роутер
//        self::$router = Router::getInstance();
//        self::$router->Init();
//        // передаем запрос на обработку маршрутизатору
//        self::$router->dispatch(Utils::getUrl());
    }
    
} 