<?php

namespace App\Categories\QueryHandler;

use App\Categories\DTO\Category;
use App\Categories\Repository\CategoryRepository;
use App\ValueObject\CategoryId;

class GetCategoryHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $id):Category
    {
        return $this->repository->getCategoryById(new CategoryId($id));
    }
}
