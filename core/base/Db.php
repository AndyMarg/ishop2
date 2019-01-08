<?php

namespace core\base;

use core\libs\TSingleton;

/**
 * Менеджер БД
 */
class Db {
    private $db;
    private $log = [];
            
    use TSingleton;
    
    /**
     * Инициадизация соединения с БД
     */
    public function Init() {
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,   // выбрасывание исключений, вместо просто возврата ошибки
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC          // результвт в виде ассоциативного массива
        ];
        $config = Application::getConfig();
        $this->db = new \PDO($config->db->dsn, $config->db->user, $config->db->pass, $opt);
    }
    
    /**
     * Запрос к БД
     * 
     * @param string $sql   SQL
     * @param array $params Параметры 
     * @return array Массив записей
     */
    public function query(string $sql, array $params = []) {
        // добавляем параметры для IN(), если есть
        $this->expandQuery($sql, $params);
        // пишем в лог
        $this->addLog($sql, $params);
        // подготавливаем и выполняем запрос
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Выполняет оператор в БД
     *
     * @param string $sql   SQL
     * @param array $params Параметры
     * @return bool
     */
    public function execute(string $sql, array $params = []) {
        // добавляем параметры для IN(), если есть
        $this->expandQuery($sql, $params);
        // пишем в лог
        $this->addLog($sql, $params);
        // подготавливаем и выполняем запрос
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Логгирование запросов
     * 
     * @param string $sql  SQL
     * @param array $params Параметры запроса
     */
    private function addLog(string $sql, array $params = null) {
        $log['sql'] = $sql;
        if ($params) {
            $log['params'] = $params;
        }
        $this->log[] = $log;
    }
    
    /**
     * Добавляет параметры для IN(), если есть
     * Модифицирует и строку SQL и массив параметров
     * @param string $sql SQL
     * @param array $params Параметры
    */
    private function expandQuery(&$sql, &$params = null) {
        if (!$params) { return; }
        foreach ($params as $name => $value) {
            if (gettype($value) === 'array') {
                $s = ''; $num = 0;
                foreach ($value as $param_value) {
                    $param_name = "{$name}_{$num}";
                    $params[$param_name] = $param_value;
                    $s .= "{$param_name},";
                    $num += 1;
                }
                $inject_params = substr($s, 0, -1);
                $sql = str_replace($name, $inject_params, $sql);
                unset($params[$name]);
            }
        }
    }

    /**
     * Вернуть лог запросов
     * @return array Массив лога запросов
     */
    public function getLog() {
        return $this->log;
    }
    
    /**
     * Разметка  html для вывода лога
     */
    public function getLogHtml() {
        $html = "<div class=\"db-log\">\n";
        foreach ($this->log as $log) {
            $s = $log['sql'];
            if (array_key_exists('params', $log)) {
                foreach ($log['params'] as $name => $value) {
                    if (gettype($value) === 'string') {
                        $value = "'{$value}'";
                    }
                    $value = "<span>{$value}</span>";
                    $s = str_replace($name, $value, $s);
                }
            }
            $html .= "<p>{$s}</p>\n";
        }
        $html .= "</div>";
        return $html;
    }

    /**
     * @return string ИД последней вставленной записи
     */
    public function getLastID()
    {
        return  $this->db->lastInsertId();
    }

}
