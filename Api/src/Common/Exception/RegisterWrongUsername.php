<?php

namespace App\Exception;

final class RegisterWrongUsername extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("Nazwa użytkownika musi mieć od 6 do 13 znaków");
    }
}
