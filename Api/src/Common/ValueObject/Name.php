<?php
namespace App\ValueObject;

use Exception;

class ProductName extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value == ""){
            throw new Exception("ProductName must not be empty");
        }
    }
}