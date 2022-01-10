<?php

namespace App\Categories\QueryHandler;

use App\Categories\DTO\CategoryCollection;
use App\Categories\Repository\DBALCategoryRepository;

class GetCollectionCategoryHandler
{
    private DBALCategoryRepository $repository;

    public function __construct(DBALCategoryRepository $repository)
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
