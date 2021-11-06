<?php
namespace App\Products\Repository;

use App\Products\DTO\ProductCollection;
use App\Products\Factory\ProductCollectionFactory;
use Doctrine\DBAL\Connection;

class ProductsRepository implements ProductsRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;   
    }

    public function GetAllProducts():ProductCollection
    {

        $rawResult = $this->connection->createQueryBuilder()
        ->select('p.id as id, c.name as category, p.name as name, price, IFNULL(0,SUM(rating))/5 as rating')
        ->from('products','p')
        ->leftJoin('p','opinions','o','o.product_id = p.id')
        ->join('p','categories','c','c.id = p.category_id')
        ;
        $rawResult->execute();
        $rawResult = $rawResult->fetchAllAssociative();
        return ProductCollectionFactory::CreateFromArray($rawResult);
    }
}