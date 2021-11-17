<?php
namespace App\Products\QueryHandler;

use App\Products\DTO\ProductCollection;
use App\Products\Repository\ProductRepositoryInterface;

class GetProductCollectionHandler
{
    private ProductRepositoryInterface $repository;
    
    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle():ProductCollection
    {
        return $this->repository->GetAllProducts();
    }
}