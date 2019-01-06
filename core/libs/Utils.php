<?php

namespace core\libs;

//use core\base\Application;
use core\base\Application;

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
        return strpos($r, '?') !== false ?  trim(substr($r, 0, strpos($r, '?')), '/') : $r;
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

    /**
     * Редирект на заданную страницу или на исходную (или на корень, если не задано ничего)
     *
     * @param string $url Страница для редиректа
     */
    public static function redirect($url = null) {
        if (!empty($url)) {
            $redirect = $url;
        } else {
            $referer = filter_input(INPUT_SERVER, 'HTTP_REFERER');
            $redirect = isset($referer) ? filter_input(INPUT_SERVER, 'HTTP_REFERER') : Application::getConfig()->dirs->root;
        }
        header("Location: $redirect");
        exit;
    }

    /**
     * Экранирует специальные символы в html коде
     * @param string $str Строка для очистки
     * @return string Очищенная строка
     */
    public static function htmlClear($str)
    {
        return htmlspecialchars($str, ENT_QUOTES);
    }
}
