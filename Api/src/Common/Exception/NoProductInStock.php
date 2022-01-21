<?php

namespace App\Exception;

final class NoProductInStock extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("No product in stock");
    }
}
