<?php
namespace App\ValueObject;

use Exception;

class CategoryName extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value == ""){
            throw new Exception("Category name must not be empty");
        }
    }
}