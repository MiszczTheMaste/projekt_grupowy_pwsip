<?php

namespace App\Exception;

final class CouldNotRegisterUser extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("Could not register user");
    }
}
