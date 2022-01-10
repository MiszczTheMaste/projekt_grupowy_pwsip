<?php
namespace App\Rating\DTO;

use App\ValueObject\ProductId;
use App\ValueObject\Rating;
use App\ValueObject\Username;

class Rate
{
    private ProductId $productId;
    private Rating $rating;
    private Username $username;

    public function __construct(ProductId $productId, Rating $rating, Username $username)
    {
        $this->productId = $productId;
        $this->rating = $rating;
        $this->username = $username;
    }

    public function getProductId():ProductId
    {
        return $this->productId;
    }    

    public function getRating():Rating
    {
        return $this->rating;
    }   

    public function getUsername():Username
    {
        return $this->username;
    }
}