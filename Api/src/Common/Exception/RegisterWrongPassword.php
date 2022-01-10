<?php

namespace App\Exception;

final class RegisterWrongPassword extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("Hasło musi mieć minimum 6 znaków");
    }
}
