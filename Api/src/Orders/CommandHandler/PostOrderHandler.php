<?php
namespace App\Orders\CommandHandler;

use App\Orders\Factory\OrderFactory;
use App\Orders\Repository\OrderRepository;

class PostOrderHandler
{
    private OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $username, array $products): void
    {
        $date = date("Y-m-d H:i:s");
        $newOrder = OrderFactory::createOrder($date, $username, $products);
        $this->repository->insertOrder($newOrder);
    }
}