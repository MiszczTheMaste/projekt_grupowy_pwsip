<?php
namespace App\Orders\Factory;

use App\Orders\DTO\OrderCollection;

class OrderCollectionFactory
{
    public static function createCollection(array $array):OrderCollection
    {
        $collection = array();
        foreach($array as $row){
            $collection[] = OrderFactory::createOrder($row['date'],$row['username'],json_decode($row['products']));
        }
        return new OrderCollection($collection);
    }
}