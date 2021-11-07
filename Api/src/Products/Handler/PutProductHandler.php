<?php
namespace App\Products\Handler;

use App\Products\DTO\Product;
use App\Products\Factory\ProductFactory;
use App\Products\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class PutProductHandler
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Request $request): bool
    {
        $data = json_decode($request->getContent(),true);
        $newProduct = ProductFactory::CreateFromArray([
            'id' => null,
            'name' => $data['name'],
            'category' => $data['category'],
            'price' => $data['price'],
            'rating' => null,
            'stock' => null
        ]);
        return $this->repository->putProduct($newProduct);
    }
}