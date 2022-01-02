<?php
namespace App\Products\CommandHandler;

use App\Products\Factory\ProductFactory;
use App\Products\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class PostProductHandler
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
            'categoryId' => $data['categoryId'],
            'price' => $data['price'],
            'rating' => null,
            'stock' => null
        ]);
        return $this->repository->putProduct($newProduct);
    }
}