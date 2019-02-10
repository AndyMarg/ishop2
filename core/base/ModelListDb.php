<?php

namespace core\base;


/**
 * Список моделей из ДБ
 */
class ModelListDb extends ModelList {

    private $options = [];              // свойства модели
    private $source = [];               // данные из базы в виде массива (индексирован по порядку)

    private $needPagination;            // необходиа ли пагинация
    private $page = null;               // текущий номер страницы
    private $countOnPage;               // количество записей на странице
    private $total;                     // общее количество записей в выборке
    private $countPages;                // количество страниц в выборке

    /**
     * ModelListDb constructor.
     * @param array $options Настройки модели (sql и т.д.)
     * @throws \Exception
     */
    public function __construct(array $options) {
        $this->options = $options;

        // для расчета пагинации
        if (key_exists('count_on_page', $this->options)) {
            $this->countOnPage = $this->options['count_on_page'];
        } else {
            $this->countOnPage = Application::getConfig()->interface->pagination->rows_on_page;
        }
        $this->total = $this->getCountRecords();
        $this->countPages = ceil($this->total / $this->countOnPage) ?: 1;
        $this->needPagination = ($this->countOnPage < $this->total);
        if (key_exists('need_pagination', $this->options) && !$this->options['need_pagination']) {
            $this->needPagination = false;
        }

        // пробуем получить из хранилища, если задана установка для хранилища
        if (isset($options['storage'])) {
             $this->source = Application::getStorage()->get($options['storage']);
        }
        // если их хранилища не получили, получаем из БД
        if (empty($this->source)) {
            $this->source = $this->load();
        }
        // сохраняем в хранилище, если задана установка для хранилища 
        if (!empty($this->source) && isset($options['storage'])) {
             Application::getStorage()->set($options['storage'], $this->source);
        }

        parent::__construct($this->source, $options['class'] );
    }

    /**
     * Загружаем данные списка моделей из БД
     *
     * @return array
     * @throws \Exception
     */
    private function load() {
        if (!key_exists('sql', $this->options) || empty($this->options['sql'])) {
            throw new \Exception("Not defined SQL for model list");
        }
        $sql = $this->options['sql'];
        // диапазон выборки строк
        $limit = '';
        $this->page = 1;
        if ($this->needPagination && key_exists('page', $this->options) && $this->options['page'] !== false) {
            $this->page = $this->options['page'];
            if ($this->page < 1) $this->page = 1;
            if ($this->page > $this->countPages) $this->page = $this->countPages;
            $current = ($this->page - 1) * $this->countOnPage;
            $limit = ' limit '. $current . ',' .  $this->countOnPage;
        }
        $sql .= $limit;
        // параметры
        $params = [];
        if (key_exists('params', $this->options) && !empty($this->options['params'])) {
            $params = $this->options['params'];
        }
        return Application::getDb()->query($sql, $params);
    }

    /**
     * @return int Количество строк результата запроса
     * @throws \Exception
     */
    public function getCountRecords()
    {
        if (!key_exists('sql', $this->options) || empty($this->options['sql'])) {
            throw new \Exception("Not defined SQL for model list");
        }
        $sql = $this->options['sql'];
        // параметры
        $params = [];
        if (key_exists('params', $this->options) && !empty($this->options['params'])) {
            $params = $this->options['params'];
        }
        // меняем строку запроса для получения количества строк
        $sql = str_replace("\r\n", ' ', $sql);
        $sql = preg_replace("#(select)(.*?)(from .*)#i", "$1 count(*) as cnt $3", $sql);
        return Application::getDb()->query($sql, $params)[0]['cnt'];
    }

    /**
     * @return int Текущая страница
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int Количество записей на странице
     */
    public function getCountOnPage()
    {
        return $this->countOnPage;
    }

    /**
     * @return int Общее количество записей в выборке
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return bool Необходима ли пагинация
     */
    public function isNeedPagination(): bool
    {
        return $this->needPagination;
    }

    /**
     * Возвращает массив данных из базы
     * @param bool $indexedById  Индексировать массив идентификаторами данных из базы
     * @return array Массив данных из базы
     */
    public function asArray(bool $indexedById = false) {
        $temp =[];
        if ($indexedById) {
            foreach ($this->source as $item) {
                $temp[$item['id']] = $item;
            }
        } else {
            $temp = $this->source;
        }
        return $temp;
    }
}

