<?php
namespace App\Products\DTO;

use App\Products\ValueObjects\Name;
use App\Products\ValueObjects\Price;
use App\Products\ValueObjects\Rating;
use App\Products\ValueObjects\ProductId;
use App\Products\ValueObjects\Stock;

class Product implements \JsonSerializable
{
    private ?ProductId $id;
    private Name $name;
    private int $categoryId;
    private Price $price;
    private ?Rating $rating;
    private ?Stock $stock;

    public function __construct(
        ?int $id,
        string $name,
        int $categoryId,
        float $price,
        ?float $rating,
        ?int $stock
    )
    {
        $this->id = new ProductId($id);
        $this->name = new Name($name);
        $this->categoryId = $categoryId;
        $this->price = new Price($price);
        $this->rating = new Rating($rating);
        $this->stock = new Stock($stock);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id->getValue(),
            'name' => $this->name->getValue(),
            'price' => $this->price->getValue(),
            'rating' => $this->rating->getValue(),
            'stock' => $this->stock->getValue()
        ];
    }

    public function getName()
    {
        return $this->name->getValue();
    }

    public function getPrice()
    {
        return $this->price->getValue();
    }
    
    public function getCategoryId()
    {
        return $this->categoryId;
    }
}