<?php
namespace App\Products\ValueObjects;

use Exception;

class Price extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value < 0){
            throw new Exception("Product name must be unsigned value");
        }
    }
}