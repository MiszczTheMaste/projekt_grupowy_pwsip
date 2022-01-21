<?php

namespace App\Products\CommandHandler;

use App\Products\Factory\ProductFactory;
use App\Products\Repository\ProductRepository;
use App\ValueObject\ProductId;
use Symfony\Component\HttpFoundation\Request;

class DeleteProductHandler
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $productId): void
    {
        $this->repository->deleteProduct(new ProductId($productId));
    }
}
