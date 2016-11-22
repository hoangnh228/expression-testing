<?php

class Expression
{
    protected $expression = '';

    public static function make()
    {
        return new static;
    }

    public function find($value)
    {
        // $value = $this->sanitize($value);
        // $this->expression .= $value;
        // return $this;

        return $this->add($this->sanitize($value));
    }

    public function then($value)
    {
        return $this->find($value);
    }

    public function anything()
    {
        // $this->expression .= '.*';
        // return $this;
        return $this->add('.*');
    }

    public function anythingBut($value)
    {
        $value = $this->sanitize($value);
        return $this->add("(?!$value).*?");
    }

    public function maybe($value)
    {
        $value = $this->sanitize($value);
        return $this->add("(?:$value)?");
    }

    public function getRegex()
    {
        return '/' . $this->expression . '/';
    }

    public function __toString()
    {
        return $this->getRegex();
    }

    protected function add($value)
    {
        $this->expression .= $value;
        return $this;
    }

    protected function sanitize($value)
    {
        return preg_quote($value, '/');
    }

    public function test($value)
    {
        return !! preg_match($this->getRegex(), $value);
    }
}