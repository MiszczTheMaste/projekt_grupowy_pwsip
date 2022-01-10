<?php

namespace App\Categories\Repository;

use App\Categories\DTO\Category;
use App\Categories\DTO\CategoryCollection;
use App\Categories\Factory\CategoryCollectionFactory;
use App\Categories\Factory\CategoryFactory;
use App\ValueObject\CategoryId;
use Doctrine\DBAL\Connection;

class DBALCategoryRepository implements CategoryRepository
{
    private Connection $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getCategoryById(CategoryId $id): Category
    {
        $query = $this->connection->createQueryBuilder()
            ->select('id, name, visible')
            ->from('categories', 'p')
            ->where('id = :categoryId')
            ->setParameter('categoryId', $id->getValue());;
        $query->executeQuery();
        $rawResult = $query->fetchAllAssociative();
        try {
            $rawResult = $rawResult[0];
        } catch (\Throwable $e) {
            throw $e;
        }
        return CategoryFactory::createCategoryFromArray($rawResult);
    }

    public function getCollectionCategoryOnlyVisible(): CategoryCollection
    {
        $query = $this->connection->createQueryBuilder()
            ->select('id, name, visible')
            ->from('categories', 'p')
            ->where('visible = 1');
        $query->executeQuery();
        $rawResult = $query->fetchAllAssociative();
        return CategoryCollectionFactory::createCategoryCollectionFromArray($rawResult);
    }

    public function getCollectionCategoryAll(): CategoryCollection
    {
        $query = $this->connection->createQueryBuilder()
            ->select('id, name, visible')
            ->from('categories', 'p');
        $query->executeQuery();
        $rawResult = $query->fetchAllAssociative();
        return CategoryCollectionFactory::createCategoryCollectionFromArray($rawResult);
    }

    public function insertCategory(Category $category): void
    {
        $query = $this->connection->createQueryBuilder()
            ->insert('categories')
            ->values(array(
                'name' => '?',
                'visible' => '?'
            ))
            ->setParameter(0, $category->getCategoryName()->getValue())
            ->setparameter(1, $category->getCategoryVisible());
        $query->executeQuery();
    }
}
