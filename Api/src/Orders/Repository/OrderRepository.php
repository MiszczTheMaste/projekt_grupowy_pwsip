<?php

namespace App\Orders\Repository;

use App\Orders\DTO\Order;
use App\Orders\DTO\OrderCollection;
use App\ValueObject\Username;

interface OrderRepository
{
    public function insertOrder(Order $order): void;

    public function selectOrderCollection(Username $username): OrderCollection;
}
