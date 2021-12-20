<?php

namespace App\Exception;

final class PasswordCannotBeEmpty extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("Password cannot be empty string");
    }
}
