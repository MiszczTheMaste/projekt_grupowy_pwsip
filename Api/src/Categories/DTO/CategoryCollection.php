<?php

namespace App\Categories\DTO;

class CategoryCollection implements \JsonSerializable
{
    private array $collection;

    public function __construct(array $collection){
        $this->collection = $collection;
    }

    public function jsonSerialize()
    {
        return $this->collection;
    }
}
