<?php

namespace App\Exception;

final class UsernameCannotBeEmpty extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("Username cannot be empty string");
    }
}
