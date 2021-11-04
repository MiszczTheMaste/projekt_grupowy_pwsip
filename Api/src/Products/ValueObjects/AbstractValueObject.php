<?php
namespace App\Products\ValueObjects;

abstract class AbstractValueObject
{
    protected $value;

    public function __construct($value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString():string
    {
        return (string)$this->getValue();
    }

    abstract protected function validate($value): void;
}