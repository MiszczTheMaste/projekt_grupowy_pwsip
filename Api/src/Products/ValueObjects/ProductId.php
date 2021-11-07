<?php
namespace App\Products\ValueObjects;

use Exception;

class ProductId extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value < 0 && !is_null($value)){
            throw new Exception("Product id name must be unsigned value");
        }
    }
}