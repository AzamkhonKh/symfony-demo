<?php

namespace App\Controller;

use App\DTO\ProductCreateRequest;
use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/products', name: 'api_products_')]
class ProductController extends AbstractController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(SerializerInterface $serializer): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        return new JsonResponse(
            $serializer->serialize($products, 'json', ['groups' => 'product_read']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    #[Route('', name: 'create', methods: ['POST'], defaults: ['_dto' => ProductCreateRequest::class])]
    public function create(ProductCreateRequest $validatedDto): JsonResponse
    {
        $product = new Product();
        $product->setName($validatedDto->name);
        $product->setPrice($validatedDto->price);

        $this->productService->saveProduct($product);

        return $this->json($product, JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function get(Product $product, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($product, 'json', ['groups' => 'product_read']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Product $product,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = $request->getContent();
        $serializer->deserialize($data, Product::class, 'json', ['object_to_populate' => $product]);

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string)$errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->productService->saveProduct($product);
        return $this->json($product, JsonResponse::HTTP_OK, [], ['groups' => 'product_read']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Product $product): JsonResponse
    {
        $this->productService->deleteProduct($product);
        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
