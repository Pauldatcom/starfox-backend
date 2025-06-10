<?php

namespace App\Controller\Api;

use App\Entity\EnemyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EnemyTypeController extends AbstractController
{
    #[Route('/api/enemies', name: 'api_list_enemies', methods: ['GET'])]
    public function listEnemies(EntityManagerInterface $em): JsonResponse
    {
        $enemies = $em->getRepository(EnemyType::class)->findAll();

        $data = [];
        foreach ($enemies as $enemy) {
            $data[] = [
                'id' => $enemy->getId(),
                'name' => $enemy->getName(),
                'hp' => $enemy->getHp(),
                'speed' => $enemy->getSpeed(),
                'pattern' => $enemy->getPattern(),
                'fireInterval' => $enemy->getFireInterval(),
                'modelPath' => $enemy->getModelPath(),
                'createdAt' => $enemy->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }
}
