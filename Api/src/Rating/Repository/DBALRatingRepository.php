<?php

namespace App\Rating\Repository;

use App\Products\DTO\Product;
use App\Rating\DTO\Rate;
use Doctrine\DBAL\Connection;

class DBALRatingRepository implements RatingRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function putRating(Rate $rate): void
    {
        $query = $this->connection->createQueryBuilder()
            ->insert('opinions')
            ->values(array(
                'product_id' => '?',
                'rating' => '?',
                'username' => '?'
            ))
            ->setParameter(0, $rate->getProductId())
            ->setparameter(1, $rate->getRating())
            ->setparameter(2, $rate->getUsername());
        $query->executeQuery();
    }
}
