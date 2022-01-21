<?php

namespace App\Stock\Repository;

use App\Exception\NoSuchProduct;
use App\Stock\Repository\StockRepository;
use App\ValueObject\ProductId;
use App\ValueObject\Stock;
use Doctrine\DBAL\Connection;

class DBALStockRepository implements StockRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function updateStock(ProductId $productId, int $amount): void
    {
        $product = $this->connection->createQueryBuilder()
            ->select('id')
            ->from('products', 'p')
            ->where('id = :id')
            ->setParameter('id', $productId->getValue());
        $product->executeQuery();
        $rawResult = $product->fetchAllAssociative();
        if (empty($rawResult)) {
            throw new NoSuchProduct;
        }

        $query = $this->connection->createQueryBuilder()
            ->update('products')
            ->set('stock', 'stock + ' . $amount)
            ->where('id = :id')
            ->setParameter('id', $productId->getValue());
        $query->executeQuery();
    }

    public function setStock(ProductId $productId, Stock $amount): void
    {
        $query = $this->connection->createQueryBuilder()
            ->update('products')
            ->set('stock', $amount->getValue())
            ->where('id = :id')
            ->setParameter('id', $productId->getValue());
        $query->executeQuery();
    }
}
