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
        ?int $stock
    )
    {
        $this->id = new ProductId($id);
        $this->name = new ProductName($name);
        $this->description = new NotEmptyString($description);
        $this->image = new NotEmptyString($image);
        $this->categoryId = new CategoryId($categoryId);
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
            'description' => $this->description->getValue(),
            'image' => $this->image->getValue(),
            'rating' => $this->rating->getValue(),
            'stock' => $this->stock->getValue(),
            'categoryId' => $this->categoryId->getValue()
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
}