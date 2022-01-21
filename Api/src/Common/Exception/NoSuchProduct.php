<?php

namespace App\Exception;

final class NoSuchProduct extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("No such product");
    }
}
