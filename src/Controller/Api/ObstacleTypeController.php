<?php

namespace App\Controller\Api;

use App\Entity\ObstacleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ObstacleTypeController extends AbstractController
{
    #[Route('/api/obstacles', name: 'api_list_obstacles', methods: ['GET'])]
    public function listObstacles(EntityManagerInterface $em): JsonResponse
    {
        $obstacles = $em->getRepository(ObstacleType::class)->findAll();

        $data = [];
        foreach ($obstacles as $obs) {
            $data[] = [
                'id' => $obs->getId(),
                'name' => $obs->getName(),
                'shape' => $obs->getShape(),
                'dimensions' => $obs->getDimensions(),
                'createdAt' => $obs->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }
}
