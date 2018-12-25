<?php

namespace core\libs;

/**
 * Class Pagination Постраничный просмотр
 * @package core\libs
 */
class Pagination
{
    private $current;
    private $countOnPage;
    private $total;
    private $countPages;
    private $url;
    private $links = [
        'back' => '',
        'forward' => '',
        'begin' => '',
        'end' => '',
        'left2' => '',
        'left1' => '',
        'right2' => '',
        'right1' => ''
    ];

    public function __construct(int $current, int $countOnPage, int $total)
    {
        $this->countOnPage = $countOnPage;
        $this->total = $total;
        $this->countPages = ceil($total / $countOnPage) ?: 1;
        $this->current = $this->getCurrent($current);
        $this->url = $this->getuUrl();
    }

    private function getCurrent(int $current) {
        if (!$current || $current < 1) $current = 1;
        if ($current > $this->total) $current = $this->total;
        return $current;
    }

    private function getuUrl()
    {
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $uri = preg_replace("#page=\d+&?#", '', $uri);
        $uri = preg_replace("#&$#",'',$uri) . '&';
        return urldecode($uri);
    }

    public function getStartRecord()
    {
        return ($this->current - 1) * $this->countOnPage;
    }


}
