<?php

namespace core\base;

use core\libs\ArrayAsObject;

/**
 * Управление конфигурацией. Singleton.
 */
final class Config
{
    use \core\libs\TSingleton; 
    
    private $default_config = [];   // массив данных конфигурации по умолчанию
    private $app_config = [];       // массив данных конфигурации приложения
    private $config = [];           // результирующий массив данных конфигурации
    
    private $root;                  // корень приложения в файловой системе
    
    public function getDefaultConfigArray() {return $this->default_config; }
    public function getAppConfigArray() { return $this->app_config; }
    public function getConfigArray() { return $this->config; }
    
    /**
     * корень приложения в файловой системе
     * @return string
     */
    public function getRoot() { return $this->root; }

    /**
     * Настраиваем конфигурацию в соответствии с установками в файле конфигурации приложения
     *
     * @param string $app_root Корень приложения
     * @param string $app_config_file
     * @throws \Exception
     */
    public function Init(string $app_root, string $app_config_file = "")
    {
        $this->root = $app_root;
        
        // считываем конфигурацию по умолчанию
        $file = $app_root . '/core/config_default.php';
        if (!file_exists($file)) {
            throw new \Exception('Not found default config data file: ' . $file);
        }
        $this->default_config = include_once $file;

        // считываем конфигурацию приложения
        if (!empty($app_config_file)) {
            $file = $app_root . $app_config_file;
            if (!file_exists($file)) {
                throw new \Exception('Not found application config data file: ' . $file);
            }
           $this->app_config = include_once $file;
        }
        // перезаписываем конфигурацию по умолчанию конфигурацией приложения
        $this->config = array_replace_recursive($this->default_config, $this->app_config);
    }
    
    /**
     * Доступ в свойству конфигурации
     * 
     * @param string $property
     * @return mixed
     */
    public function __get($property) {
        $object = new ArrayAsObject($this->config);
        return $object->$property;
    }
    
}
