<?php

namespace core\libs;

use core\base\ModelListDb;

/**
 * Class Pagination Постраничный просмотр
 * @package core\libs
 */
class Pagination
{
    private $current;               // текущая страница
    private $countOnPage;           // количество записей на странице
    private $total;                 // общее количество записей в выборке
    private $countPages;            // количество страниц
    private $url;                   // url без параметра вида page=N

    /**
     * Pagination constructor.
     * @param ModelListDb $model Модель
     */
    public function __construct(ModelListDb $model)
    {
        $this->countOnPage = $model->getCountOnPage();
        $this->total = $model->getTotal();
        $this->countPages = ceil($this->total / $this->countOnPage) ?: 1;
        $this->current = $this->getCurrent($model->getPage());
        $this->url = $this->getuUrl();
    }

    /**
     * @return string HTML-код пагинации
     */
    public function getHtml()
    {
        $back = null;
        $forward = null;
        $begin = null;
        $end = null;
        $left2 = null;
        $left1 = null;
        $right2 = null;
        $right1 = null;

       if ($this->current > 1) {
            $back = "<li><a class='nav-link' href='{$this->url}page=" . ($this->current - 1) . "'>&lt;</a></li>";
        }
        if ($this->current < $this->countPages) {
            $forward = "<li><a class='nav-link' href='{$this->url}page=" . ($this->current + 1) . "'>&gt;</a></li>";
        }
        if ($this->current > 3) {
            $begin = "<li><a class='nav-link' href='{$this->url}page=1'>&laquo;</a></li>";
        }
        if ($this->current < ($this->countPages - 2)) {
            $end = "<li><a class='nav-link' href='{$this->url}page=" . ($this->countPages + 1) . "'>&raquo;</a></li>";
        }
        if (($this->current - 1) > 0) {
            $left1 = "<li><a class='nav-link' href='{$this->url}page=" . ($this->current - 1) . "'>" . ($this->current - 1) . "</a></li>";
        }
        if (($this->current - 2) > 0) {
            $left2 = "<li><a class='nav-link' href='{$this->url}page=" . ($this->current - 2) . "'>" . ($this->current - 2) . "</a></li>";
        }
        if (($this->current + 1) <= $this->countPages) {
            $right1 = "<li><a class='nav-link' href='{$this->url}page=" . ($this->current + 1) . "'>" . ($this->current + 1) . "</a></li>";
        }
        if (($this->current + 2) <= $this->countPages) {
            $right2 = "<li><a class='nav-link' href='{$this->url}page=" . ($this->current + 2) . "'>" . ($this->current + 2) . "</a></li>";
        }
        return '<ul class="pagination">' .$begin.$back.$left2.$left1. '<li class="active"><a>'.$this->current.'</a></li>' .$right1.$right2.$forward.$end. '</ul>';
    }


    /**
     * Уточнить текущую страницу
     * @param int $current
     * @return int
     */
    private function getCurrent(int $current) {
        if (!$current || $current < 1) $current = 1;
        if ($current > $this->countPages) $current = $this->countPages;
        return $current;
    }

    /**
     * @return string Удалить из url параметр вида page=N
     */
    private function getuUrl()
    {
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $uri = preg_replace("#page=\d+&?#", '', $uri);
        $uri = preg_replace("#(\/|\/\?|&)$#",'',$uri);
        $uri .= (preg_match("#\/?\?#", $uri)) === 1 ? '&' : '/?';

        preg_match_all("#filter=[\d,&]#", $uri, $matches);
        if (count($matches[0]) > 1) {
            $uri = preg_replace("#filter=[\d,&]+#", '', $uri, 1);
        }

        return urldecode($uri);
    }

}
