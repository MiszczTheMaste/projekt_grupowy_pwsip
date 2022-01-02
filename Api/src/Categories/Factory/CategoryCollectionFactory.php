<?php

namespace App\Categories\Factory;

use App\Categories\DTO\Category;
use App\Categories\DTO\CategoryCollection;

class CategoryCollectionFactory
{
    public static function createCategoryCollectionFromArray(array $rawResult):CategoryCollection
    {
        $collection = [];
        foreach($rawResult as $row){
            $collection[] = new Category($row['id'], $row['name'], $row['visible']); 
        }
        return new CategoryCollection($collection);
    }
}
