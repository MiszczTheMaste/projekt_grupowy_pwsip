<?php
namespace App\Products\ValueObjects;

use Exception;

class Name extends abstractValueObject
{
    protected function validate($value): void
    {
        if($value = ""){
            throw new Exception("Product name must not be empty");
        }
    }
}