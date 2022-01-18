<?php

namespace App\Products\DTO;

use App\ValueObject\CategoryId;
use App\ValueObject\ProductName;
use App\ValueObject\Price;
use App\ValueObject\Rating;
use App\ValueObject\ProductId;
use App\ValueObject\Stock;
use App\ValueObject\NotEmptyString;

class Product implements \JsonSerializable
{
    private ?ProductId $id;
    private ProductName $name;
    private CategoryId $categoryId;
    private NotEmptyString $description;
    private NotEmptyString $image;
    private array $specs;
    private Price $price;
    private ?Rating $rating;
    private ?Stock $stock;

    public function __construct(
        ?int $id,
        string $name,
        int $categoryId,
        string $description,
        string $image,
        float $price,
        ?float $rating,
        ?int $stock,
        array $specs
    ) {
        $this->id = new ProductId($id);
        $this->name = new ProductName($name);
        $this->description = new NotEmptyString($description);
        $this->image = new NotEmptyString($image);
        $this->categoryId = new CategoryId($categoryId);
        $this->price = new Price($price);
        $this->rating = new Rating($rating);
        $this->stock = new Stock($stock);
        $this->specs = $specs;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id->getValue(),
            'name' => $this->name->getValue(),
            'price' => $this->price->getValue(),
            'description' => $this->description->getValue(),
            'image' => $this->image->getValue(),
            'rating' => $this->rating->getValue(),
            'stock' => $this->stock->getValue(),
            'categoryId' => $this->categoryId->getValue(),
            'specs' => $this->specs
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

    public function getImage()
    {
        return $this->categoryId;
    }

    public function getDescription()
    {
        return $this->categoryId;
    }    
    
    public function getSpecs()
    {
        return $this->specs;
    }
}
