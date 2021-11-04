<?php
namespace App\Products\Factory;

use App\Products\DTO\ProductCollection;

class ProductCollectionFactory
{
    public static function CreateFromArray(array $array):ProductCollection
    {
        $collection = array();
        foreach($array as $row){
            $collection[] = ProductFactory::CreateFromArray($row);
        }
        return new ProductCollection($collection);
    }
}