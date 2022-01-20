<?php

namespace App\Products\Repository;

use App\Products\DTO\Product;
use App\Products\DTO\ProductCollection;
use App\Products\Factory\ProductCollectionFactory;
use App\Products\Factory\ProductFactory;
use App\ValueObject\Username;
use Doctrine\DBAL\Connection;

class DBALProductRepository implements ProductRepository
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
            c.id as categoryId, 
            p.name as name, 
            p.description as description,
            p.image as image,
            price, 
            IFNULL(AVG(rating),0) as rating,
            p.stock,
            p.specs
        ')
            ->from('products', 'p')
            ->leftJoin('p', 'opinions', 'o', 'o.product_id = p.id')
            ->leftJoin('p', 'categories', 'c', 'c.id = p.category_id')
            ->GroupBy('p.id');
        $query->executeQuery();
        $rawResult = $query->fetchAllAssociative();
        return ProductCollectionFactory::CreateFromArray($rawResult);
    }

    public function GetProductsByIdArray(array $productsIds): ProductCollection
    {
        $query = $this->connection->createQueryBuilder()
            ->select('
            p.id as id, 
            c.id as categoryId, 
            p.name as name, 
            p.description as description,
            p.image as image,
            price, 
            IFNULL(AVG(rating),0) as rating,
            p.stock,
            specs
        ')
            ->from('products', 'p')
            ->leftJoin('p', 'opinions', 'o', 'o.product_id = p.id')
            ->leftJoin('p', 'categories', 'c', 'c.id = p.category_id')
            ->where("p.id IN (:productsIds)")
            ->setParameter('productsIds', array_values($productsIds), \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)
            ->GroupBy('p.id');

        $query->executeQuery();
        $rawResult = $query->fetchAllAssociative();
        return ProductCollectionFactory::CreateFromArray($rawResult);
    }

    public function GetProductById(int $productId): Product
    {

        $rawResult = $this->connection->createQueryBuilder()
            ->select(
                'p.id as id, 
                c.id as categoryId, 
                p.name as name, 
                p.description as description,
                p.image as image,
                price, 
                IFNULL(AVG(rating),0) as rating,
                p.stock,
                specs
            '
            )
            ->from('products', 'p')
            ->leftJoin('p', 'opinions', 'o', 'o.product_id = p.id')
            ->join('p', 'categories', 'c', 'c.id = p.category_id')
            ->where('p.id = :productId')
            ->setParameter('productId', $productId);
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
            'category_id' => '?',
            'image' => '?',
            'description' => '?',
            'specs' => '?',
        ))
        ->setParameter(0, $product->getName())
        ->setparameter(1, $product->getPrice())
        ->setparameter(2, $product->getCategoryId())
        ->setparameter(3, $product->getImage())
        ->setparameter(4, $product->getDescription())
        ->setparameter(5, json_encode($product->getSpecs()));
        $query->executeQuery();
        return true;
    }

    public function getRatedProducts(Username $username): ProductCollection
    {
        $query = $this->connection->createQueryBuilder()
            ->select('
            p.id as id, 
            c.id as categoryId, 
            p.name as name, 
            p.description as description,
            p.image as image,
            price, 
            IFNULL(AVG(rating),0) as rating,
            p.stock,
            specs
        ')
            ->from('products', 'p')
            ->innerJoin('p', 'opinions', 'o', 'o.product_id = p.id')
            ->leftJoin('p', 'categories', 'c', 'c.id = p.category_id')
            ->where("o.username = (:username)")
            ->setParameter('username', $username->getValue())
            ->GroupBy('p.id');

        $query->executeQuery();
        $rawResult = $query->fetchAllAssociative();
        return ProductCollectionFactory::CreateFromArray($rawResult);
    }
}
