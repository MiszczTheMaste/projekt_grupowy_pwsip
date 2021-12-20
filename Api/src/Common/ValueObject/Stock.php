<?php
namespace App\ValueObject;

use Exception;

class Stock extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value < 0  && !is_null($value)){
            throw new Exception("Stock amount must be unsigned value");
        }
    }
}