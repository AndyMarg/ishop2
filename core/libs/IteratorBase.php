<?php

namespace core\libs;

/**
 * Базовый итератор по объекту, инкапсилирующему массив
 */
class IteratorBase implements \Iterator
{
    private $data = [];

    public function __construct($array)
    {
        if (is_array($array)) {
            $this->data = $array;
        }
    }

    public function rewind()
    {
        reset($this->data);
    }
  
    public function current()
    {
        $data = current($this->data);
        return $data;
    }
  
    public function key() 
    {
        $data = key($this->data);
        return $data;
    }
  
    public function next() 
    {
        $data = next($this->data);
        return $data;
    }
  
    public function valid()
    {
        $key = key($this->data);
        $data = ($key !== NULL && $key !== FALSE);
        return $data;
    }

}