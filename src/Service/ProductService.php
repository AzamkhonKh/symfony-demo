<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function saveProduct(Product $product): Product
    {
        $this->em->persist($product);
        $this->em->flush();
        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }
    // Get a product by its ID
    public function getProduct(int $productId): Product
    {
        // Attempt to fetch the product by its ID
        $product = $this->em->getRepository(Product::class)->find($productId);

        // If the product is not found, throw a NotFoundHttpException
        if (!$product) {
            throw new NotFoundHttpException("Product with ID $productId not found.");
        }

        // Return the found product
        return $product;
    }
}
