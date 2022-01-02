<?php

namespace App\Categories\QueryHandler;

use App\Categories\DTO\Category;
use App\Categories\Factory\CategoryFactory;
use App\Categories\Repository\CategoryRepository;
use App\ValueObject\CategoryId;

class PostCategoryHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
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
