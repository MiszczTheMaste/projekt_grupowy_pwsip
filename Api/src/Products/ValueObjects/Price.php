<?php
namespace App\Products\ValueObjects;

use Exception;

class Price extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value < 0){
            throw new Exception("Price must be unsigned value");
        }
    }
}