<?php
namespace App\Orders\QueryHandler;

use App\Orders\DTO\OrderCollection;
use App\Orders\Repository\OrderRepository;
use App\ValueObject\Username;

class GetOrderCollectionHandler
{
    private OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $username): OrderCollection
    {
        return $this->repository->selectOrderCollection(new Username($username));
    }
}