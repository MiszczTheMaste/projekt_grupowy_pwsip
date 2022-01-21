<?php

namespace App\Orders\Repository;

use App\Exception\NoProductInStock;
use App\Orders\DTO\Order;
use App\Orders\DTO\OrderCollection;
use App\Orders\Factory\OrderCollectionFactory;
use App\Stock\CommandHandler\UpdateStockHandler;
use App\ValueObject\Username;
use Doctrine\DBAL\Connection;

class DBALOrderRepository implements OrderRepository
{
    private Connection $connection;

    private UpdateStockHandler $stockHandler;

    public function __construct(Connection $connection, UpdateStockHandler $stockHandler)
    {
        $this->connection = $connection;
        $this->stockHandler = $stockHandler;
    }

    public function insertOrder(Order $order): void
    {
        $this->connection->beginTransaction();

        try {
            foreach ($order->getProductsId() as $product) {
                $this->stockHandler->handle($product, -1);
            }
        } catch (\Throwable $th) {
            $this->connection->rollBack();
            throw new NoProductInStock;
        }


        $query = $this->connection->createQueryBuilder()
            ->insert('orders')
            ->values(array(
                'date' => '?',
                'username' => '?',
                'products' => '?'
            ))
            ->setParameter(0, $order->getDate()->format('Y-m-d H:i:s'))
            ->setparameter(1, $order->getUsername()->getValue())
            ->setparameter(2, json_encode($order->getProductsId()));
        $query->executeQuery();

        $this->connection->commit();
    }

    public function selectOrderCollection(Username $username): OrderCollection
    {
        $query = $this->connection->createQueryBuilder()
            ->select('
               id,
               date,
               username,
               products
            ')
            ->from('orders', 'p')
            ->where('username = :username')
            ->setParameter('username', $username->getValue());
        $query->executeQuery();
        $rawResult = $query->fetchAllAssociative();
        return OrderCollectionFactory::createCollection($rawResult);
    }
}
