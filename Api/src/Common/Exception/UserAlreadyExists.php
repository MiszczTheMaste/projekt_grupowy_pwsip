<?php

namespace App\Exception;

final class UserAlreadyExists extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("User already exists");
    }
}
