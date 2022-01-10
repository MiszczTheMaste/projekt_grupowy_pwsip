<?php
namespace App\Rating\CommandHandler;

use App\Rating\Factory\RatingFactory;
use App\Rating\Repository\RatingRepository;

class PostRatingHandler
{
    private RatingRepository $repository;

    public function __construct(RatingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $productId, int $rating, string $userId): void
    {
        $newRate = RatingFactory::CreateRate($productId, $rating, $userId);
        $this->repository->putRating($newRate);
    }
}