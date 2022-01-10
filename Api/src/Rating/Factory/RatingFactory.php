<?php
namespace App\Rating\Factory;

use App\Rating\DTO\Rate;
use App\ValueObject\ProductId;
use App\ValueObject\Rating;
use App\ValueObject\Username;

class RatingFactory
{
    public static function CreateRate(int $productId, int $rating, string $username):Rate
    {
        return new Rate(new ProductId($productId), new Rating($rating), new Username($username));
    }
}