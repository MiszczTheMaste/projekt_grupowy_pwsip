<?php

namespace App\Categories\Factory;

use App\Categories\DTO\Category;

class CategoryFactory
{
    public static function createCategoryFromArray(array $rawResult):Category
    {
        return new Category($rawResult['id'], $rawResult['name'], $rawResult['visible']);
    }
}
