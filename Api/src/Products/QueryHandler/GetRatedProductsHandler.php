<?php
namespace App\Products\QueryHandler;

use App\Products\DTO\ProductCollection;
use App\Products\Repository\ProductRepository;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\ValueObject\Username;

class GetRatedProductsHandler
{
    private ProductRepository $repository;
    private Security $security;
    
    public function __construct(ProductRepository $repository, Security $security)
    {
        $this->repository = $repository;
        $this->security = $security;
    }

    public function handle():ProductCollection
    {
        $user = $this->security->getUser();
        $username = $user->getUserIdentifier();
        $username = new Username($username);
        
        return $this->repository->GetRatedProducts($username);   
    }
}