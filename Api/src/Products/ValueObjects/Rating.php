<?php
namespace App\Products\ValueObjects;

use Exception;

class Rating extends AbstractValueObject
{
    protected function validate($value): void
    {
        if(($value < 0 || $value > 5) && !is_null($value)){
            throw new Exception("Rating must be unsigned value smaller tor equal to 5");
        }
    }
}