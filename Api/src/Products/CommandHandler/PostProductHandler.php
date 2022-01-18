<?php
namespace App\Products\CommandHandler;

use App\Products\Factory\ProductFactory;
use App\Products\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class PostProductHandler
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Request $request): bool
    {
        $data = json_decode($request->getContent(),true);
        $data['id'] = null;
        $data['rating'] = null;
        $data['stock'] = null;
        $data['specs'] = json_encode($data['specs']);
        $newProduct = ProductFactory::CreateFromArray($data);
        return $this->repository->putProduct($newProduct);
    }
}