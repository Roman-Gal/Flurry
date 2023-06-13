<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Menu;

/**
 * @Route("/api", name="api_")
 */
class MenuController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/menu", name="get_all_positions", methods={"GET"})
     */
    public function getAllPositions(): JsonResponse
    {
        $postions = $this->entityManager->getRepository(Menu::class)->findAll();
        if (!$postions) {
            return $this->json(['error' => 'Positions not found'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($postions);
    }

    /**
     * @Route("/menu/{id}",name="get_position", methods={"GET"})
     */
    public function getOnePositionById(int $id): JsonResponse
    {
        $menu = $this->entityManager->getRepository(Menu::class)->find($id);
        if (!$menu) {
            return $this->json(['error' => 'Position not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($menu);
    }

    /**
     * @Route("/menu", name="add_position", methods={"POST"})
     */
    public function addNewPosition(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $menu = new Menu();
        $menu->setTitle($data['title']);
        $menu->setPrice($data['price']);
        $menu->setDateCreate(new \DateTimeImmutable());
        $menu->setDateModified(new \DateTime());

        $menu->setDescription($data['description'] ?? null);
        $menu->setImage($data['image'] ?? null);
        
        $this->entityManager->persist($menu);
        $this->entityManager->flush();

        return $this->json($menu);
    }

    /**
     * @Route("/menu/{id}",name="edit_position", methods={"PUT", "PATCH"})
     */
    public function updatePositionById(Request $request, int $id ): JsonResponse
    {
        $menu = $this->entityManager->getRepository(Menu::class)->find($id);

        if (!$menu) {
            return $this->json(['error' => 'Position not found'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);

        $menu->setTitle($data['title'] ?? null);
        $menu->setDescription($data['description'] ?? null);
        $menu->setPrice($data['price'] ?? null);
        $menu->setImage($data['image'] ?? null);

        $menu->setDateModified(new \DateTime());

        $this->entityManager->persist($menu);
        $this->entityManager->flush();

        return $this->json($menu);
    }

    /**
     * @Route("/menu/{id}", name="delete_position", methods={"DELETE"})
     */
    public function deletePostionById(int $id): JsonResponse
    {
        $menu = $this->entityManager->getRepository(Menu::class)->find($id);

        if (!$menu) {
            return $this->json(['error' => 'Position not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->persist($menu);
        $this->entityManager->remove($menu);
        $this->entityManager->flush();;

        return $this->json(['message' => 'Position '.$menu->getTitle().' deleted successfully.']);
    }
}
