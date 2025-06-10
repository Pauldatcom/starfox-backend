<?php

namespace App\Controller\Api;

use App\Entity\Level;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LevelController extends AbstractController
{
    #[Route('/api/levels/{id}', name: 'api_get_level', methods: ['GET'])]
    public function getLevel(Level $level): JsonResponse
    {
        return $this->json([
            'id' => $level->getId(),
            'name' => $level->getName(),
            'jsonData' => $level->getJsonData(),
            'createdAt' => $level->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }

    #[Route('/api/levels', name: 'api_list_levels', methods: ['GET'])]
    public function listLevels(EntityManagerInterface $em): JsonResponse
    {
        $levels = $em->getRepository(Level::class)->findAll();

        $data = [];
        foreach ($levels as $level) {
            $data[] = [
                'id' => $level->getId(),
                'name' => $level->getName(),
                'createdAt' => $level->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return $this->json($data);
    }
}
