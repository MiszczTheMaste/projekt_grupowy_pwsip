<?php
namespace App\Products\DTO;

use App\Products\ValueObjects\Name;
use App\Products\ValueObjects\Price;
use App\Products\ValueObjects\Rating;

class Product implements \JsonSerializable
{
    private int $id;
    private Name $name;
    private Price $price;
    private Rating $rating;

    public function __construct(
        int $id,
        string $name,
        float $price,
        float $rating,
    )
    {
        $this->id = $id;
        $this->name = new Name($name);
        $this->price = new Price($price);
        $this->rating = new Rating($rating);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name->getValue(),
            'price' => $this->price->getValue(),
            'rating' => $this->rating->getValue()
        ];
    }
}