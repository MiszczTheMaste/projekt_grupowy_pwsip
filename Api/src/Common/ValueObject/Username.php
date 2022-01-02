<?php
namespace App\ValueObject;

use App\Exception\UsernameCannotBeEmpty;

class Username extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value == ""){
            throw new UsernameCannotBeEmpty;
        }
    }
}