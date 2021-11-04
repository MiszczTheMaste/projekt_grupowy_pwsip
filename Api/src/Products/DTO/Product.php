<?php
namespace App\Products\DTO;

use App\Products\ValueObjects\Name;
use App\Products\ValueObjects\Price;

class Product implements \JsonSerializable
{
    private int $id;
    private Name $name;
    private Price $price;

    public function __construct(
        int $id,
        string $name,
        float $price,
    )
    {
        $this->id = $id;
        $this->name = new Name($name);
        $this->price = new Price($price);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name->getValue(),
            'price' => $this->price->getValue()
        ];
    }
}