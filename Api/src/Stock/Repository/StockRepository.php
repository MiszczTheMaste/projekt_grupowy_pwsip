<?php
namespace App\Stock\Repository;

use App\ValueObject\ProductId;
use App\ValueObject\Stock;

interface StockRepository
{
    public function updateStock(ProductId $productId, int $amount):void;

    public function setStock(ProductId $productId, Stock $amount):void;
}