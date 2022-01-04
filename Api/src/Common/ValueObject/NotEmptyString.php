<?php
namespace App\ValueObject;

use Exception;

class NotEmptyString extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value == ""){
            throw new Exception("String must not be empty");
        }
    }
}