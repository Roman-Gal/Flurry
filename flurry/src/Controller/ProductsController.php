<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Products;
/**
 * @Route("/api", name="api_")
 */
class ProductsController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/products", name="get_all_products", methods={"GET"})
     */
    public function getAllProducts(): JsonResponse
    {
        $products = $this->entityManager->getRepository(Products::class)->findAll();

        if (!$products) {
            return $this->json(['error' => 'Products not found'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($products);
    }

    /**
     * @Route("/products/{id}", name="get_product", methods={"GET"})
     */
    public function getOneProductById(int $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Products::class)->find($id);
        if (!$product) {
            return $this->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($product);
    }

    /**
     * @Route("/products", name="add_product", methods={"POST"})
     */
    public function addNewProduct(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $product = new Products();
        $product->setTitle($requestData['title']);
        $product->setPrice($requestData['price']);
        $product->setDateCreate(new \DateTimeImmutable());
        $product->setDateModified(new \DateTime());

        $product->setProductImage($requestData['product_image'] ?? null);
        $product->setProductType($requestData['product_type'] ?? null);   
        $product->setProductDescription($requestData['product_description'] ?? null);
        $product->setQuantity($requestData['quantity'] ?? null);
        $product->setProductLikes($requestData['likes'] ?? null);
        $product->setProductTags($requestData['tags'] ?? null);

        // Save the new product to the database
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $this->json($product, Response::HTTP_CREATED);
    }
    /**
     * @Route("/products/{id}", name="edit_product", methods={"PUT", "PATCH"})
     */
    public function updateProductById(Request $request, int $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Products::class)->find($id);

        if (!$product) {
            return $this->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $product->setDateModified(new \DateTime());

        $product->setTitle($requestData['title'] ?? null);
        $product->setPrice($requestData['price'] ?? null);
        $product->setProductImage($requestData['product_image'] ?? null);
        $product->setProductType($requestData['product_type'] ?? null);   
        $product->setProductDescription($requestData['product_description'] ?? null);
        $product->setQuantity($requestData['quantity'] ?? null);
        $product->setProductLikes($requestData['likes'] ?? null);
        $product->setProductTags($requestData['tags'] ?? null);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $this->json($product);
    }

    /**
     * @Route("/products/{id}", name="delete_product", methods={"DELETE"})
     */
    public function deleteProductById(int $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Products::class)->find($id);
        if (!$product) {
            return $this->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->persist($product);
        $this->entityManager->remove($product);
        $this->entityManager->flush();
        return $this->json(['message' => 'Product '.$product->getTitle().' succesfully deleted']);
    }
}