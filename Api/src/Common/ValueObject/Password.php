<?php
namespace App\ValueObject;

use App\Exception\PasswordCannotBeEmpty;

class Password extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value = ""){
            throw new PasswordCannotBeEmpty;
        }
    }
}