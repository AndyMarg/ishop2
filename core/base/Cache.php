<?php

namespace core\base;

use core\libs\Utils;

/**
 * Класс кэша
 */
class Cache {
    
    /**
     * Сохранить данные в кэше
     * @param string $key
     * @param mixed $data
     * @param int $seconds
     * @return boolean
     */
    public static function save(string $key, $data, int $seconds = 3600) {
        if ($seconds) {
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;
            $file = Utils::getRoot() .'/'.  Application::getConfig()->dirs->cache . '/' . md5($key) . '.txt';
            if (file_put_contents($file, serialize($content)))  {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * Получить данные из кэша
     * @param string $key
     * @return boolean
     */
    public static function load($key) {
        $file = Utils::getRoot() .'/'.  Application::getConfig()->dirs->cache . '/' . md5($key) . '.txt';
        if (is_file($file)) {
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time']) {
                return $content['data'];
            } else { 
                unlink($file);
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * Очистить ланные в кэше
     * @param string $key
     */
    public static function clear($key) {
        $file = Utils::getRoot() .'/'.  Application::getConfig()->dirs->cache . '/' . md5($key) . '.txt';
        if (is_file($file)) {
            unlink($file);
        }
    }
    
}
