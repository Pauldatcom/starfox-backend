<?php

namespace App\Controller\Api;

use App\Entity\EnemyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EnemyTypeController extends AbstractController
{
    #[Route('/api/enemy-types', name: 'api_list_enemy_types', methods: ['GET'])]
    public function listEnemyTypes(EntityManagerInterface $em): JsonResponse
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
                'createdAt' => $enemy->getCreatedAt()?->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }

    #[Route('/api/enemy-types/{id}', name: 'api_show_enemy_type', methods: ['GET'])]
    public function showEnemyType($id, EntityManagerInterface $em): JsonResponse
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

    #[Route('/api/enemy-types', name: 'api_create_enemy_type', methods: ['POST'])]
    public function createEnemyType(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $enemy = new EnemyType();
        $enemy->setName($data['name'] ?? '');
        $enemy->setHp($data['hp'] ?? 0);
        $enemy->setSpeed($data['speed'] ?? 0);
        $enemy->setPattern($data['pattern'] ?? '');
        $enemy->setFireInterval($data['fireInterval'] ?? 0);
        $enemy->setModelPath($data['modelPath'] ?? '');
        $enemy->setCreatedAt(new \DateTimeImmutable());

        // VALIDATION ici
        $errors = $validator->validate($enemy);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $em->persist($enemy);
        $em->flush();

        return $this->json(['message' => 'EnemyType created', 'id' => $enemy->getId()], 201);
    }

    #[Route('/api/enemy-types/{id}', name: 'api_update_enemy_type', methods: ['PUT'])]
    public function updateEnemyType($id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
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

        // VALIDATION ici
        $errors = $validator->validate($enemy);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $em->flush();
        return $this->json(['message' => 'EnemyType updated']);
    }

    #[Route('/api/enemy-types/{id}', name: 'api_delete_enemy_type', methods: ['DELETE'])]
    public function deleteEnemyType($id, EntityManagerInterface $em): JsonResponse
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
