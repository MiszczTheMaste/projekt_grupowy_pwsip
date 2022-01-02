<?php

namespace App\Categories\DTO;

use App\ValueObject\CategoryId;
use App\ValueObject\CategoryName;

class Category implements \JsonSerializable
{
    private CategoryId $id;

    private CategoryName $categoryName;

    private bool $visible;

    public function __construct(?int $id, string $categoryName, bool $visible){
        $this->id = new CategoryId($id);
        $this->categoryName = new CategoryName($categoryName);
        $this->visible = $visible;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id->getValue(),
            'name' => $this->categoryName->getValue(),
            'visible' => $this->visible
        ];
    }    
    
    public function getCategoryId()
    {
        return $this->id;
    }   
    
    public function getCategoryName()
    {
        return $this->categoryName;
    }   
    
    public function getCategoryVisible()
    {
        return $this->visible;
    }
}
