<?php
namespace App\Products\Repository;

use App\Products\DTO\ProductCollection;
use App\Products\Factory\ProductCollectionFactory;

class ProductsRepository implements ProductsRepositoryInterface
{
    public function GetAllProducts():ProductCollection
    {
        //TODO
        //Zrobić bazę danychn na to i połączenie do niej
        $rawResult = array(
            ['id' => 1, 'name' => 'test1', 'price' => 5.1],
            ['id' => 2, 'name' => 'test2', 'price' => 5.2],
            ['id' => 3, 'name' => 'test3', 'price' => 5.3],
        );
        return ProductCollectionFactory::CreateFromArray($rawResult);
    }
}