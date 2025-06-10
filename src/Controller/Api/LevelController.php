<?php

namespace App\Controller\Api;

use App\Entity\Level;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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



    // Create a new level


    #[Route('/api/levels', name: 'api_create_level', methods: ['POST'])]
public function createLevel(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $level = new Level();
    $level->setName($data['name'] ?? '');
    $level->setJsonData($data['jsonData'] ?? '');
    $level->setCreatedAt(new \DateTimeImmutable());

    $em->persist($level);
    $em->flush();

    return $this->json(['message' => 'Level created', 'id' => $level->getId()], 201);
}




// Modify a level


#[Route('/api/levels/{id}', name: 'api_update_level', methods: ['PUT'])]
public function updateLevel($id, Request $request, EntityManagerInterface $em): JsonResponse
{
    $level = $em->getRepository(Level::class)->find($id);
    if (!$level) {
        return $this->json(['error' => 'Level not found'], 404);
    }

    $data = json_decode($request->getContent(), true);
    if (isset($data['name'])) $level->setName($data['name']);
    if (isset($data['jsonData'])) $level->setJsonData($data['jsonData']);

    $em->flush();

    return $this->json(['message' => 'Level updated']);
}





// Delete a level



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
