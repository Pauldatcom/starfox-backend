<?php

namespace App\Controller\Api;

use App\Entity\EnemyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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


    // Find an enemy by its ID

    #[Route('/api/enemies/{id}', name: 'api_show_enemy', methods: ['GET'])]
public function showEnemy($id, EntityManagerInterface $em): JsonResponse
{
    $enemy = $em->getRepository(EnemyType::class)->find($id);
    if (!$enemy) {
        return $this->json(['error' => 'EnemyType not found'], 404);
    }
    $data = [
        'id' => $enemy->getId(),
        'name' => $enemy->getName(),
        'hp' => $enemy->getHp(),
        'speed' => $enemy->getSpeed(),
        'pattern' => $enemy->getPattern(),
        'fireInterval' => $enemy->getFireInterval(),
        'modelPath' => $enemy->getModelPath(),
        'createdAt' => $enemy->getCreatedAt()?->format('Y-m-d H:i:s'),
    ];
    return $this->json($data);
}




// Create a ennemy



#[Route('/api/enemies', name: 'api_create_enemy', methods: ['POST'])]
public function createEnemy(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $enemy = new EnemyType();
    $enemy->setName($data['name'] ?? '');
    $enemy->setHp($data['hp'] ?? 100);
    $enemy->setSpeed($data['speed'] ?? 1);
    $enemy->setPattern($data['pattern'] ?? '');
    $enemy->setFireInterval($data['fireInterval'] ?? 1);
    $enemy->setModelPath($data['modelPath'] ?? '');
    $enemy->setCreatedAt(new \DateTimeImmutable());

    $em->persist($enemy);
    $em->flush();

    return $this->json(['message' => 'EnemyType created', 'id' => $enemy->getId()], 201);
}




// Update an enemy


#[Route('/api/enemies/{id}', name: 'api_update_enemy', methods: ['PUT'])]
public function updateEnemy($id, Request $request, EntityManagerInterface $em): JsonResponse
{
    $enemy = $em->getRepository(EnemyType::class)->find($id);
    if (!$enemy) {
        return $this->json(['error' => 'EnemyType not found'], 404);
    }
    $data = json_decode($request->getContent(), true);

    if (isset($data['name'])) $enemy->setName($data['name']);
    if (isset($data['hp'])) $enemy->setHp($data['hp']);
    if (isset($data['speed'])) $enemy->setSpeed($data['speed']);
    if (isset($data['pattern'])) $enemy->setPattern($data['pattern']);
    if (isset($data['fireInterval'])) $enemy->setFireInterval($data['fireInterval']);
    if (isset($data['modelPath'])) $enemy->setModelPath($data['modelPath']);

    $em->flush();
    return $this->json(['message' => 'EnemyType updated']);
}



// Delete an enemy


#[Route('/api/enemies/{id}', name: 'api_delete_enemy', methods: ['DELETE'])]
public function deleteEnemy($id, EntityManagerInterface $em): JsonResponse
{
    $enemy = $em->getRepository(EnemyType::class)->find($id);
    if (!$enemy) {
        return $this->json(['error' => 'EnemyType not found'], 404);
    }
    $em->remove($enemy);
    $em->flush();
    return $this->json(['message' => 'EnemyType deleted']);
}

}
