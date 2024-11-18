<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductServiceTest extends KernelTestCase
{
    private ProductService $productService;
    private EntityManagerInterface $entityManager;

    // This method runs before each test
    protected function setUp(): void
    {
        self::bootKernel(); // Boot Symfony kernel

        // Get EntityManager and ProductService from the container
        // $this->entityManager = self::$kernel->getContainer()->get(EntityManagerInterface::class);
        $this->entityManager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->productService = new ProductService($this->entityManager);
    }

    // Test to create and save a product
    public function testSaveProduct(): void
    {
        $product = new Product();
        $product->setName('Test Product');
        $product->setPrice(99.99);

        // Save the product using the ProductService
        $this->productService->saveProduct($product);

        // Refresh the product entity to get the latest persisted data
        $this->entityManager->refresh($product);

        // Assertions to ensure the product is persisted correctly
        $this->assertNotNull($product->getId());  // Assert that the product has an ID
        $this->assertEquals('Test Product', $product->getName());  // Assert the correct name
        $this->assertEquals(99.99, $product->getPrice());  // Assert the correct price
    }

    // Test to retrieve all products
    public function testGetAllProducts(): void
    {
        // Create and save a product
        $product = new Product();
        $product->setName('Test Product');
        $product->setPrice(99.99);
        $this->productService->saveProduct($product);

        // Retrieve all products
        $products = $this->productService->getAllProducts();

        // Assertions to check that we have at least 1 product in the database
        $this->assertGreaterThan(0, count($products));  // Assert that products list is not empty
        $this->assertContains($product, $products);  // Assert that the created product is in the list
    }
    // Test that deleting a product actually removes it from the database
    public function testDeleteProductFromDatabase(): void
    {
        // Create and save a product
        $product = new Product();
        $product->setName('Test Product');
        $product->setPrice(99.99);
        $this->productService->saveProduct($product);
        $productId = $product->getId();
        // Retrieve and check that the product exists
        $existingProduct = $this->productService->getProduct($productId);
        $this->assertEquals('Test Product', $existingProduct->getName());

        // Delete the product
        $this->productService->deleteProduct($product);

        // Attempt to retrieve the product again, expecting a NotFoundHttpException
        $this->expectException(NotFoundHttpException::class);
        $this->productService->getProduct($productId);
    }
}
