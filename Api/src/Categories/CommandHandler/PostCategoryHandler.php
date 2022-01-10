<?php

namespace App\Categories\QueryHandler;

use App\Categories\DTO\Category;
use App\Categories\Factory\CategoryFactory;
use App\Categories\Repository\DBALCategoryRepository;
use App\ValueObject\CategoryId;

class PostCategoryHandler
{
    private DBALCategoryRepository $repository;

    public function __construct(DBALCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(array $request):void
    {
        $request['id'] = null;
        $category = CategoryFactory::createCategoryFromArray($request);
        $this->repository->insertCategory($category);
    }
}
