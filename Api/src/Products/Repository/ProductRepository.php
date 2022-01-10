<?php
namespace App\Products\Repository;

use App\Products\DTO\ProductCollection;
use App\Products\DTO\Product;

interface ProductRepository
{
    public function GetAllProducts():ProductCollection;

    public function GetProductsByIdArray(array $productsIds):ProductCollection;

    public function GetProductById(int $productId):Product;

    public function putProduct(Product $product):bool;
}