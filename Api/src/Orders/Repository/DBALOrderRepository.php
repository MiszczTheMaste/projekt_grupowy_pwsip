<?php

namespace App\Orders\Repository;

use App\Orders\DTO\Order;
use App\Orders\DTO\OrderCollection;
use App\Orders\Factory\OrderCollectionFactory;
use App\ValueObject\Username;
use Doctrine\DBAL\Connection;

class DBALOrderRepository implements OrderRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function insertOrder(Order $order): void
    {
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
