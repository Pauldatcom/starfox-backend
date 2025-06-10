<?php

namespace App\Controller\Api;

use App\Entity\Spaceship;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SpaceshipController extends AbstractController
{
    #[Route('/api/spaceships', name: 'api_list_spaceships', methods: ['GET'])]
    public function listSpaceships(EntityManagerInterface $em): JsonResponse
    {
        $spaceships = $em->getRepository(Spaceship::class)->findAll();

        $data = [];
        foreach ($spaceships as $ship) {
            $data[] = [
                'id' => $ship->getId(),
                'name' => $ship->getName(),
                'baseHp' => $ship->getBaseHp(),
                'baseSpeed' => $ship->getBaseSpeed(),
                'maxBombs' => $ship->getMaxBombs(),
                'createdAt' => $ship->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $ship->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }
}
