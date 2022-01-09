<?php
namespace App\Products\QueryHandler;

use App\Products\DTO\ProductCollection;
use App\Products\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class GetProductCollectionHandler
{
    private ProductRepositoryInterface $repository;
    
    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Request $request):ProductCollection
    {
        $data = json_decode($request->getContent(),true);
        if(isset($data['products'])){
            return $this->repository->GetProductsByIdArray($data['products']);
        } else {
            return $this->repository->GetAllProducts();
        }     
    }
}