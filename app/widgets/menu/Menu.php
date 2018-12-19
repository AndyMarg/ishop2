<?php

namespace app\widgets\menu;

use core\base\Widget;

/**
 * Виджет меню
 */
class Menu extends Widget {
    
    // данные для построения иерархии меню
    private $data;
    // данные меню в виде дерева
    private $tree;
    // тэг контейнера
    protected $containerHtmlTag  = 'ul';
    // css класс контейнера меню
    protected $cssClass = 'menu-widget';
    // html аттрибуты
    protected $htmlAttributes = [];
    // html разметка, добавленная перед выводом меню
    protected $prependHtml;


    public function __construct($data, $options = []) {
        foreach ($data as $value) {
            $this->data[(int)$value['id']] = $value;
        }
        $this->tree = $this->getTree();
        parent::__construct('menu', $options);
    }
    
    /**
     * Строим иерархический массив из плоского массива
     * @return type
     */
    private function getTree() {
        $tree = [];
        $data = $this->data;
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }
    
    /**
     * Выводим html шаблон меню.
     * Переопределяет метод родителя
     */
    protected function outputTemplate() {
        // сформировать локальные переменные
        extract($this->getData());
        // сформировать строку аттрибутов
        $attrs = '';
        foreach ($this->htmlAttributes as $name => $value) {
            $attrs .= " {$name}=\"{$value}\" ";
        }
        echo "<{$this->containerHtmlTag} class=\"{$this->cssClass}\" {$attrs}>";
        echo $this->prependHtml;
        $this->getChildsHtml($this->tree);
        echo "</{$this->containerHtmlTag}>";
    }
    
    /**
     * Выводим один уровень меню
     * @param type $tree
     * @param type $tab
     */
    protected function getChildsHtml($tree, $tab = '') {
        foreach ($tree as $id => $category) {
            require $this->getTpl();
        }
    }
    
}
