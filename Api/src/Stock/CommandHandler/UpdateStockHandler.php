<?php
namespace App\Stock\CommandHandler;

use App\Stock\Repository\StockRepository;
use App\ValueObject\ProductId;

class UpdateStockHandler
{
    private StockRepository $repository;

    public function __construct(StockRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $productId, int $amount): void
    {
        $this->repository->updateStock(new ProductId($productId), $amount);
    }
}