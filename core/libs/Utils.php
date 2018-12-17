<?php

namespace core\libs;

//use core\base\Application;

/**
 * Служебные методы
 *
 * @author Andrey.Margashov
 */
class Utils {
    
    /**
     * Возвращает путь к корню приложения в файловой системе на сервере
     *
     * @return string
     */
    public static function getRoot() {
         return filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');   
    }
    
    /**
     * Возвращает часть url без строки параметров
     *
     * @return string
     */
    public static function getUrl() {
        $r = trim(filter_input(INPUT_SERVER, 'REQUEST_URI'), '/');
        $result = trim(substr($r, 0, strpos($r, '?')), '/');
        return $result;
    }
 
    /**
     * Возвращает строку параметров
     *
     * @return string
     */
    public static function getQueryString() {
        $r = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $result = substr($r, strpos($r, '?')+1);
        return $result;
    }
    
//    public static function redirect($url = false) {
//        if ($url) {
//            $redirect = $url;
//        } else {
//            $referer = filter_input(INPUT_SERVER, 'HTTP_REFERER');
//            $redirect = isset($referer) ? filter_input(INPUT_SERVER, 'HTTP_REFERER') : Application::getConfig()->dirs->root;
//        }
//        header("Location: $redirect");
//        exit;
//    }
}
