<?php

namespace App\Categories\QueryHandler;

use App\Categories\DTO\CategoryCollection;
use App\Categories\Repository\CategoryRepository;

class GetCollectionCategoryHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(bool $onlyVisible):CategoryCollection
    {
        if($onlyVisible){
            return $this->repository->getCollectionCategoryOnlyVisible();
        } else{
            return $this->repository->getCollectionCategoryAll();
        } 
    }
}
