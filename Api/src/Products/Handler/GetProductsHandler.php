<?php
namespace App\Products\Handler;

use App\Products\DTO\ProductCollection;
use App\Products\Repository\ProductsRepositoryInterface;

class GetProductsHandler
{
    private ProductsRepositoryInterface $repository;
    
    public function __construct(ProductsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle():ProductCollection
    {
        return $this->repository->GetAllProducts();
    }
}