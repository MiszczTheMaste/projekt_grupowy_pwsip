<?php

namespace App\Categories\Repository;

use App\Categories\DTO\Category;
use App\Categories\DTO\CategoryCollection;
use App\ValueObject\CategoryId;

interface CategoryRepository
{
    public function getCategoryById(CategoryId $id): Category; 
    
    public function getCollectionCategoryOnlyVisible(): CategoryCollection;

    public function getCollectionCategoryAll(): CategoryCollection;

    public function insertCategory(Category $category): void;
}
