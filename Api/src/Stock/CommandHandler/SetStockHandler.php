<?php
namespace App\Stock\CommandHandler;

use App\Stock\Repository\StockRepository;
use App\ValueObject\ProductId;
use App\ValueObject\Stock;

class SetStockHandler
{
    private StockRepository $repository;

    public function __construct(StockRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $productId, int $amount): void
    {
        $this->repository->setStock(new ProductId($productId), new Stock($amount));
    }
}