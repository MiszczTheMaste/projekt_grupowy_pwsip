<?php
namespace App\Products\Repository;

use App\Products\DTO\ProductCollection;
use App\Products\DTO\Product;

interface ProductRepositoryInterface
{
    public function GetAllProducts():ProductCollection;

    public function GetProductById(int $productId):Product;

    public function putProduct(Product $product):bool;
}