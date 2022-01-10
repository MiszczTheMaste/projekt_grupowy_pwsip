<?php
namespace App\ValueObject;

use App\Exception\PasswordCannotBeEmpty;
use App\Exception\RegisterWrongPassword;

class Password extends AbstractValueObject
{
    protected function validate($value): void
    {
        if($value == ""){
            throw new PasswordCannotBeEmpty;
        }
        if(strlen($value) < 6){
            throw new RegisterWrongPassword;
        }
    }
}