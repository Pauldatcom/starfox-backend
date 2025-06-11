<?php

namespace App\Controller\Api;

use App\Entity\ObstacleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ObstacleTypeController extends AbstractController
{
    #[Route('/api/obstacle-types', name: 'api_list_obstacle_types', methods: ['GET'])]
    public function listObstacleTypes(EntityManagerInterface $em): JsonResponse
    {
        $obstacleTypes = $em->getRepository(ObstacleType::class)->findAll();
        $data = [];
        foreach ($obstacleTypes as $obstacleType) {
            $data[] = [
            'id' => $obstacleType->getId(),
            'name' => $obstacleType->getName(),
            'shape' => $obstacleType->getShape(),
            'dimensions' => $obstacleType->getDimensions(),
            'createdAt' => $obstacleType->getCreatedAt()?->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }

    #[Route('/api/obstacles/{id}', name: 'api_show_obstacle_type', methods: ['GET'])]
    public function showObstacleType($id, EntityManagerInterface $em): JsonResponse
    {
        $obstacleType = $em->getRepository(ObstacleType::class)->find($id);
        if (!$obstacleType) {
            return $this->json(['error' => 'ObstacleType not found'], 404);
        }
        $data = [
                'id' => $obstacleType->getId(),
                'name' => $obstacleType->getName(),
                'shape' => $obstacleType->getShape(),
                'dimensions' => $obstacleType->getDimensions(),
                'createdAt' => $obstacleType->getCreatedAt()?->format('Y-m-d H:i:s'),
        ];
        return $this->json($data);
    }

    #[Route('/api/obstacle-types', name: 'api_create_obstacle_type', methods: ['POST'])]
    public function createObstacleType(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $obstacleType = new ObstacleType();
        $obstacleType->setName($data['name'] ?? '');
        $obstacleType->setDescription($data['description'] ?? '');
        $obstacleType->setColor($data['color'] ?? '');
        $obstacleType->setSize($data['size'] ?? 0);
        $obstacleType->setCollision($data['collision'] ?? false);

        // VALIDATION ici
        $errors = $validator->validate($obstacleType);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $em->persist($obstacleType);
        $em->flush();

        return $this->json(['message' => 'ObstacleType created', 'id' => $obstacleType->getId()], 201);
    }

    #[Route('/api/obstacle-types/{id}', name: 'api_update_obstacle_type', methods: ['PUT'])]
    public function updateObstacleType($id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $obstacleType = $em->getRepository(ObstacleType::class)->find($id);
        if (!$obstacleType) {
            return $this->json(['error' => 'ObstacleType not found'], 404);
        }
        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) $obstacleType->setName($data['name']);
        if (isset($data['description'])) $obstacleType->setDescription($data['description']);
        if (isset($data['color'])) $obstacleType->setColor($data['color']);
        if (isset($data['size'])) $obstacleType->setSize($data['size']);
        if (isset($data['collision'])) $obstacleType->setCollision($data['collision']);

        // VALIDATION ici
        $errors = $validator->validate($obstacleType);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $em->flush();
        return $this->json(['message' => 'ObstacleType updated']);
    }

    #[Route('/api/obstacle-types/{id}', name: 'api_delete_obstacle_type', methods: ['DELETE'])]
    public function deleteObstacleType($id, EntityManagerInterface $em): JsonResponse
    {
        $obstacleType = $em->getRepository(ObstacleType::class)->find($id);
        if (!$obstacleType) {
            return $this->json(['error' => 'ObstacleType not found'], 404);
        }
        $em->remove($obstacleType);
        $em->flush();
        return $this->json(['message' => 'ObstacleType deleted']);
    }
}
