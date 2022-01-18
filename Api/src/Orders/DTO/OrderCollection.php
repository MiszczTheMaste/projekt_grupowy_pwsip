<?php

namespace App\Orders\DTO;

class OrderCollection implements \JsonSerializable
{
    private array $collection;

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public function getCollection(): array
    {
        return $this->collection;
    }

    public function jsonSerialize()
    {
        return $this->collection;
    }
}
