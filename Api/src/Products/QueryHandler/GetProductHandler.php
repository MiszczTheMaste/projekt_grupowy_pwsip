<?php
namespace App\Products\QueryHandler;

use App\Products\DTO\Product;
use App\Products\Repository\ProductRepository;

class GetProductHandler
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($productId): Product
    {
        return $this->repository->GetProductById($productId);
    }
}