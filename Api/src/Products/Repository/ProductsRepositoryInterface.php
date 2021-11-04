<?php
namespace App\Products\Repository;

use App\Products\DTO\ProductCollection;

interface ProductsRepositoryInterface
{
    public function GetAllProducts():ProductCollection;
}