<?php

namespace App\Orders\DTO;

use App\ValueObject\Username;
use DateTime;

class Order implements \JsonSerializable
{
    private DateTime $date;
    private Username $username;
    private array $productsId;

    public function __construct(DateTime $date, Username $username, array $productsId)
    {
        $this->date = $date;
        $this->username = $username;
        $this->productsId = $productsId;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getProductsId(): array
    {
        return $this->productsId;
    }

    public function jsonSerialize()
    {
        return [
            'date' => $this->date->format("Y-m-d H:i:s"),
            'username' => $this->username->getValue(),
            'products' => $this->productsId
        ];
    }
}
