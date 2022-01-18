<?php

namespace App\Orders\Factory;

use App\Orders\DTO\Order;
use App\Rating\DTO\Rate;
use App\ValueObject\ProductId;
use App\ValueObject\Rating;
use App\ValueObject\Username;
use DateTime;

class OrderFactory
{
    public static function createOrder(string $date, string $username, array $productsId): Order
    {
        return new Order(new DateTime($date), new Username($username), $productsId);
    }
}
