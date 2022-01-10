<?php
namespace App\ValueObject;

use App\Exception\RegisterWrongUsername;
use App\Exception\UsernameCannotBeEmpty;

class Username extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value == ""){
            throw new UsernameCannotBeEmpty;
        }
        if(strlen($value) < 6 || strlen($value) > 13){
            throw new RegisterWrongUsername;
        }
    }
}