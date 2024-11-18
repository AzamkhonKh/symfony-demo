<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAllProducts(): array
    {
        return $this->em->getRepository(Product::class)->findAll();
    }

    public function saveProduct(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    public function deleteProduct(Product $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }
}
