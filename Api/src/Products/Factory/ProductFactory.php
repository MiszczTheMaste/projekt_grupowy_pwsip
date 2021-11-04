<?php
namespace App\Products\Factory;

use App\Products\DTO\Product;

class ProductFactory
{
    public static function CreateFromArray(array $array):Product
    {
        return new Product(
            $array['id'],
            $array['name'],
            $array['price']
        );
    }
}