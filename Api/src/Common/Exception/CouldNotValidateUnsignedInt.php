<?php

namespace App\Exception;

final class CouldNotValidateUnsignedInt extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("Unvalid unsigned int");
    }
}
