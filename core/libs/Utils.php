<?php

namespace core\libs;

use core\base\Application;

/**
 * Служебные методы
 *
 * @author Andrey.Margashov
 */
class Utils {
    
    /**
     * Возвращает путь к корню приложения на сервере
     * @return type string
     */
    public static function getRoot() {
         return filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');   
    }
    
    /**
     * Возвращает часть url без строки параметров
     * @return type ыекштп
     */
    public static function getUrl() {
       $r1 = trim(filter_input(INPUT_SERVER, 'REQUEST_URI'), '/');
       $r2 = str_replace(filter_input(INPUT_SERVER, 'QUERY_STRING'), '', $r1);
       $result = trim(trim($r2, '?'), '/');
       return $result;
    }
 
    /**
     * Возвращает строку параметров
     * @return type string
     */
    public static function getQueryString() {
        return filter_input(INPUT_SERVER, 'QUERY_STRING');
    }
    
    public static function redirect($url = false) {
        if ($url) {
            $redirect = $url;
        } else {
            $referer = filter_input(INPUT_SERVER, 'HTTP_REFERER');
            $redirect = isset($referer) ? filter_input(INPUT_SERVER, 'HTTP_REFERER') : Application::getConfig()->dirs->root;
        }
        header("Location: $redirect");
        exit;
    }
}
