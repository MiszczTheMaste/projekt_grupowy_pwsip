<?php
namespace App\Products\DTO;

class ProductCollection implements \JsonSerializable
{
    private array $productCollection;

    public function __construct($collection)
    {
        $this->productCollection = $collection;
    }

    public function jsonSerialize()
    {
        return $this->productCollection;
    }
}