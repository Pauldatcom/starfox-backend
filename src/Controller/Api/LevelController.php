<?php

namespace App\Controller\Api;

use App\Entity\Level;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LevelController extends AbstractController
{
    #[Route('/api/levels', name: 'api_list_levels', methods: ['GET'])]
    public function listLevels(EntityManagerInterface $em): JsonResponse
    {
        $levels = $em->getRepository(Level::class)->findAll();
        $data = [];
        foreach ($levels as $level) {
            $data[] = [
                'id' => $level->getId(),
                'name' => $level->getName(),
                'jsonData' => $level->getJsonData(),
                'createdAt' => $level->getCreatedAt()?->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }

    #[Route('/api/levels/{id}', name: 'api_show_level', methods: ['GET'])]
    public function showLevel($id, EntityManagerInterface $em): JsonResponse
    {
        $level = $em->getRepository(Level::class)->find($id);
        if (!$level) {
            return $this->json(['error' => 'Level not found'], 404);
        }
        $data = [
            'id' => $level->getId(),
            'name' => $level->getName(),
            'jsonData' => $level->getJsonData(),
            'createdAt' => $level->getCreatedAt()?->format('Y-m-d H:i:s'),
        ];
        return $this->json($data);
    }

    #[Route('/api/levels', name: 'api_create_level', methods: ['POST'])]
    public function createLevel(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $level = new Level();
        $level->setName($data['name'] ?? '');
        $level->setJsonData($data['jsonData'] ?? []);
        $level->setCreatedAt(new \DateTimeImmutable());

        // VALIDATION ici
        $errors = $validator->validate($level);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $em->persist($level);
        $em->flush();

        return $this->json(['message' => 'Level created', 'id' => $level->getId()], 201);
    }

    #[Route('/api/levels/{id}', name: 'api_update_level', methods: ['PUT'])]
    public function updateLevel($id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $level = $em->getRepository(Level::class)->find($id);
        if (!$level) {
            return $this->json(['error' => 'Level not found'], 404);
        }
        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) $level->setName($data['name']);
        if (isset($data['jsonData'])) $level->setJsonData($data['jsonData']);

        // VALIDATION ici
        $errors = $validator->validate($level);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $em->flush();
        return $this->json(['message' => 'Level updated']);
    }

    #[Route('/api/levels/{id}', name: 'api_delete_level', methods: ['DELETE'])]
    public function deleteLevel($id, EntityManagerInterface $em): JsonResponse
    {
        $level = $em->getRepository(Level::class)->find($id);
        if (!$level) {
            return $this->json(['error' => 'Level not found'], 404);
        }
        $em->remove($level);
        $em->flush();
        return $this->json(['message' => 'Level deleted']);
    }
}
