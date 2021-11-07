<?php

namespace App\Products\Repository;

use App\Products\DTO\Product;
use App\Products\DTO\ProductCollection;
use App\Products\Factory\ProductCollectionFactory;
use App\Products\Factory\ProductFactory;
use Doctrine\DBAL\Connection;

class ProductRepository implements ProductRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function GetAllProducts(): ProductCollection
    {

        $query = $this->connection->createQueryBuilder()
            ->select('
            p.id as id, 
            c.id as category, 
            p.name as name, 
            price, 
            IFNULL(0,SUM(rating))/5 as rating,
            IFNULL(0,sum(amount_left)) as stock
        ')
            ->from('products', 'p')
            ->leftJoin('p', 'opinions', 'o', 'o.product_id = p.id')
            ->leftJoin('p', 'categories', 'c', 'c.id = p.category_id')
            ->leftJoin('p', 'stock', 's', 'p.id = s.product_id AND s.amount_left > 0');
        $query->executeQuery();
        $rawResult = $query->fetchAllAssociative();
        return ProductCollectionFactory::CreateFromArray($rawResult);
    }

    public function GetProductById(int $productId): Product
    {

        $rawResult = $this->connection->createQueryBuilder()
            ->select(
                'p.id as id, 
                c.id as category, 
                p.name as name, 
                price, 
                IFNULL(0,SUM(rating))/5 as rating,
                IFNULL(0,sum(amount_left)) as stock
            '
            )
            ->from('products', 'p')
            ->leftJoin('p', 'opinions', 'o', 'o.product_id = p.id')
            ->join('p', 'categories', 'c', 'c.id = p.category_id')
            ->leftJoin('p', 'stock', 's', 'p.id = s.product_id AND s.amount_left > 0')
            ->where('p.id = :productId')
            ->setParameter('productId', $productId);;
        $rawResult->executeQuery();
        $rawResult = $rawResult->fetchAllAssociative();
        return ProductFactory::CreateFromArray($rawResult[0]);
    }

    public function putProduct(Product $product): bool
    {
        $query = $this->connection->createQueryBuilder()
        ->insert('products')
        ->values(array(
            'name' => '?',
            'price' => '?',
            'category_id' => '?'
        ))
        ->setParameter(0, $product->getName())
        ->setparameter(1, $product->getPrice())
        ->setparameter(2, $product->getCategoryId());
        $query->executeQuery();
        return true;
    }
}
