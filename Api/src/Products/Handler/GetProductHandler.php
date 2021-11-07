<?php
namespace App\Products\Handler;

use App\Products\DTO\Product;
use App\Products\Repository\ProductRepositoryInterface;

class GetProductHandler
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle($productId): Product
    {
        return $this->repository->GetProductById($productId);
    }
}