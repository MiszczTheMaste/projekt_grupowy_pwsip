<?php
namespace App\Rating\Repository;

use App\Rating\DTO\Rate;

interface RatingRepository
{
    public function putRating(Rate $rate): void;
}