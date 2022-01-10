<?php

namespace App\Categories\QueryHandler;

use App\Categories\DTO\Category;
use App\Categories\Repository\DBALCategoryRepository;
use App\ValueObject\CategoryId;

class GetCategoryHandler
{
    private DBALCategoryRepository $repository;

    public function __construct(DBALCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $id):Category
    {
        return $this->repository->getCategoryById(new CategoryId($id));
    }
}
