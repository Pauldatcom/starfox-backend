<?php

namespace App\Controller\Api;

use App\Entity\Spaceship;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SpaceshipController extends AbstractController
{
    #[Route('/api/spaceships', name: 'api_list_spaceships', methods: ['GET'])]
    public function listSpaceships(EntityManagerInterface $em): JsonResponse
    {
        $spaceships = $em->getRepository(Spaceship::class)->findAll();
        $data = [];
        foreach ($spaceships as $spaceship) {
            $data[] = [
                'id' => $spaceship->getId(),
                'name' => $spaceship->getName(),
                'health' => $spaceship->getHealth(),       // Côté API, c'est "health"
                'speed' => $spaceship->getSpeed(),         // et "speed"
                'maxBombs' => $spaceship->getMaxBombs(),   // idem
                'createdAt' => $spaceship->getCreatedAt()?->format('Y-m-d H:i:s'),
                'updatedAt' => $spaceship->getUpdatedAt()?->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }

    #[Route('/api/spaceships/{id}', name: 'api_show_spaceship', methods: ['GET'])]
    public function showSpaceship($id, EntityManagerInterface $em): JsonResponse
    {
        $spaceship = $em->getRepository(Spaceship::class)->find($id);
        if (!$spaceship) {
            return $this->json(['error' => 'Spaceship not found'], 404);
        }
        $data = [
                 'id' => $spaceship->getId(),
                'name' => $spaceship->getName(),
                'health' => $spaceship->getHealth(),       // Côté API, c'est "health"
                'speed' => $spaceship->getSpeed(),         // et "speed"
                'maxBombs' => $spaceship->getMaxBombs(),   // idem
                'createdAt' => $spaceship->getCreatedAt()?->format('Y-m-d H:i:s'),
                'updatedAt' => $spaceship->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
        return $this->json($data);
    }

    #[Route('/api/spaceships', name: 'api_create_spaceship', methods: ['POST'])]
    public function createSpaceship(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $spaceship = new Spaceship();
        $spaceship->setName($data['name'] ?? '');
        $spaceship->setHealth($data['health'] ?? 0);
        $spaceship->setSpeed($data['speed'] ?? 0);
        $spaceship->setModel($data['model'] ?? '');
        $spaceship->setLevelRequired($data['levelRequired'] ?? 0);
        $spaceship->setCreatedAt(new \DateTimeImmutable());

        // VALIDATION ici
        $errors = $validator->validate($spaceship);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $em->persist($spaceship);
        $em->flush();

        return $this->json(['message' => 'Spaceship created', 'id' => $spaceship->getId()], 201);
    }

    #[Route('/api/spaceships/{id}', name: 'api_update_spaceship', methods: ['PUT'])]
    public function updateSpaceship($id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $spaceship = $em->getRepository(Spaceship::class)->find($id);
        if (!$spaceship) {
            return $this->json(['error' => 'Spaceship not found'], 404);
        }
        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) $spaceship->setName($data['name']);
        if (isset($data['health'])) $spaceship->setHealth($data['health']);
        if (isset($data['speed'])) $spaceship->setSpeed($data['speed']);
        if (isset($data['model'])) $spaceship->setModel($data['model']);
        if (isset($data['levelRequired'])) $spaceship->setLevelRequired($data['levelRequired']);

        // VALIDATION ici
        $errors = $validator->validate($spaceship);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $em->flush();
        return $this->json(['message' => 'Spaceship updated']);
    }

    #[Route('/api/spaceships/{id}', name: 'api_delete_spaceship', methods: ['DELETE'])]
    public function deleteSpaceship($id, EntityManagerInterface $em): JsonResponse
    {
        $spaceship = $em->getRepository(Spaceship::class)->find($id);
        if (!$spaceship) {
            return $this->json(['error' => 'Spaceship not found'], 404);
        }
        $em->remove($spaceship);
        $em->flush();
        return $this->json(['message' => 'Spaceship deleted']);
    }
}
