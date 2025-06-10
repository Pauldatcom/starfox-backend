<?php

namespace App\Controller\Api;

use App\Entity\Spaceship;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

// See a spaceship by its ID

    #[Route('/api/spaceships/{id}', name: 'api_show_spaceship', methods: ['GET'])]
public function showSpaceship($id, EntityManagerInterface $em): JsonResponse
{
    $ship = $em->getRepository(Spaceship::class)->find($id);
    if (!$ship) {
        return $this->json(['error' => 'Spaceship not found'], 404);
    }
    $data = [
        'id' => $ship->getId(),
        'name' => $ship->getName(),
        'baseHp' => $ship->getBaseHp(),
        'baseSpeed' => $ship->getBaseSpeed(),
        'maxBombs' => $ship->getMaxBombs(),
        'createdAt' => $ship->getCreatedAt()?->format('Y-m-d H:i:s'),
        'updatedAt' => $ship->getUpdatedAt()?->format('Y-m-d H:i:s'),
    ];
    return $this->json($data);
}





// Create a ship 



#[Route('/api/spaceships', name: 'api_create_spaceship', methods: ['POST'])]
public function createSpaceship(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $ship = new Spaceship();
    $ship->setName($data['name'] ?? '');
    $ship->setBaseHp($data['baseHp'] ?? 100);
    $ship->setBaseSpeed($data['baseSpeed'] ?? 10);
    $ship->setMaxBombs($data['maxBombs'] ?? 1);
    $ship->setCreatedAt(new \DateTimeImmutable());
    $ship->setUpdatedAt(new \DateTimeImmutable());

    $em->persist($ship);
    $em->flush();

    return $this->json(['message' => 'Spaceship created', 'id' => $ship->getId()], 201);
}




// Update a ship

#[Route('/api/spaceships/{id}', name: 'api_update_spaceship', methods: ['PUT'])]
public function updateSpaceship($id, Request $request, EntityManagerInterface $em): JsonResponse
{
    $ship = $em->getRepository(Spaceship::class)->find($id);
    if (!$ship) {
        return $this->json(['error' => 'Spaceship not found'], 404);
    }
    $data = json_decode($request->getContent(), true);

    if (isset($data['name'])) $ship->setName($data['name']);
    if (isset($data['baseHp'])) $ship->setBaseHp($data['baseHp']);
    if (isset($data['baseSpeed'])) $ship->setBaseSpeed($data['baseSpeed']);
    if (isset($data['maxBombs'])) $ship->setMaxBombs($data['maxBombs']);

    $ship->setUpdatedAt(new \DateTimeImmutable());

    $em->flush();
    return $this->json(['message' => 'Spaceship updated']);
}




// Delete a ship

#[Route('/api/spaceships/{id}', name: 'api_delete_spaceship', methods: ['DELETE'])]
public function deleteSpaceship($id, EntityManagerInterface $em): JsonResponse
{
    $ship = $em->getRepository(Spaceship::class)->find($id);
    if (!$ship) {
        return $this->json(['error' => 'Spaceship not found'], 404);
    }
    $em->remove($ship);
    $em->flush();
    return $this->json(['message' => 'Spaceship deleted']);
}

}
