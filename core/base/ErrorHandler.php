<?php

namespace core\base;

use Exception;

/**
 * Обработчик ошибок
 *
 * @author Andrey.Margashov
 */
class ErrorHandler {
    
    public function __construct() {
        // отключение показа ошибок на продакшене
        if (Application::getConfig()->mode === 'development') {
            error_reporting(E_ALL);
        } else {
            // устанавливаем перехватчик ошибок
            set_exception_handler([$this, 'exceptionHandler']);
        }
    }

    /**
     * Обработчик исключений
     * @param \Exception $e
     */
    public function exceptionHandler($e) {
        $this->log($e);
        $this->displayErrorPage($e);
    }
    
    /**
     * Логируем исключения
     * @param \Exception $e Исключение
     */
    private function log($e) {
        $config = Application::getConfig();
        error_log(
            "[" . date('Y-m-d H:I:s') . "] Ошибка: {$e->getMessage()} | Файл: {$e->getFile()} | Строка: {$e->getLine()}\n", 
            3, $config->getRoot() . $config->errors->log);
    }
    
    /**
     * Отображаем странице на продакшене при исключении
     * @param Exception $e
     * @param int $responseCode Код возврата HTTP. Если пустой - бере код возврата из исключения
     */
    private function displayErrorPage($e, $responseCode = NULL) {
        $config = Application::getConfig();
        $code = empty($responseCode) ? $e->getCode() : $responseCode;
        http_response_code($code);
        if (Application::getConfig()->mode !=='development') {
            if ($code === 404) {
                require $config->getRoot() . Application::getConfig()->errors->pages->page404;
            } else {
                require $config->getRoot() . Application::getConfig()->errors->pages->page_common;
            }
            die;    
        }
    }
    
}
