<?php
namespace App\Products\Repository;

use App\Products\DTO\ProductCollection;
use App\Products\DTO\Product;
use App\ValueObject\Username;

interface ProductRepository
{
    public function GetAllProducts():ProductCollection;

    public function GetProductsByIdArray(array $productsIds):ProductCollection;

    public function GetProductById(int $productId):Product;

    public function putProduct(Product $product):bool;

    public function getRatedProducts(Username $username):ProductCollection;
}