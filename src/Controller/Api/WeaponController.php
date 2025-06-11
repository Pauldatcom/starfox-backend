<?php

namespace App\Controller\Api;

use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WeaponController extends AbstractController
{
    // Lister toutes les armes
    #[Route('/api/weapons', name: 'api_list_weapons', methods: ['GET'])]
    public function listWeapons(EntityManagerInterface $em): JsonResponse
    {
        $weapons = $em->getRepository(Weapon::class)->findAll();
        $data = [];
        foreach ($weapons as $weapon) {
            $data[] = [
                'id' => $weapon->getId(),
                'name' => $weapon->getName(),
                'damage' => $weapon->getDamage(),
                'cooldown' => $weapon->getCooldown(),
                'type' => $weapon->getType(),
                'levelRequired' => $weapon->getLevelRequired(),
                'createdAt' => $weapon->getCreatedAt()?->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }

    // Voir une arme par son id
    #[Route('/api/weapons/{id}', name: 'api_show_weapon', methods: ['GET'])]
    public function showWeapon($id, EntityManagerInterface $em): JsonResponse
    {
        $weapon = $em->getRepository(Weapon::class)->find($id);
        if (!$weapon) {
            return $this->json(['error' => 'Weapon not found'], 404);
        }
        $data = [
            'id' => $weapon->getId(),
            'name' => $weapon->getName(),
            'damage' => $weapon->getDamage(),
            'cooldown' => $weapon->getCooldown(),
            'type' => $weapon->getType(),
            'levelRequired' => $weapon->getLevelRequired(),
            'createdAt' => $weapon->getCreatedAt()?->format('Y-m-d H:i:s'),
        ];
        return $this->json($data);
    }

    // Créer une arme
    #[Route('/api/weapons', name: 'api_create_weapon', methods: ['POST'])]
    public function createWeapon(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $weapon = new Weapon();
        $weapon->setName($data['name'] ?? '');
        $weapon->setDamage($data['damage'] ?? 0);
        $weapon->setCooldown($data['cooldown'] ?? 0);
        $weapon->setType($data['type'] ?? '');
        $weapon->setLevelRequired($data['levelRequired'] ?? 0);
        $weapon->setCreatedAt(new \DateTimeImmutable());

        // VALIDATION ici
        $errors = $validator->validate($weapon);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $em->persist($weapon);
        $em->flush();

        return $this->json(['message' => 'Weapon created', 'id' => $weapon->getId()], 201);
    }

    // Modifier une arme
    #[Route('/api/weapons/{id}', name: 'api_update_weapon', methods: ['PUT'])]
    public function updateWeapon($id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $weapon = $em->getRepository(Weapon::class)->find($id);
        if (!$weapon) {
            return $this->json(['error' => 'Weapon not found'], 404);
        }
        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) $weapon->setName($data['name']);
        if (isset($data['damage'])) $weapon->setDamage($data['damage']);
        if (isset($data['cooldown'])) $weapon->setCooldown($data['cooldown']);
        if (isset($data['type'])) $weapon->setType($data['type']);
        if (isset($data['levelRequired'])) $weapon->setLevelRequired($data['levelRequired']);

        // VALIDATION ici
        $errors = $validator->validate($weapon);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $em->flush();
        return $this->json(['message' => 'Weapon updated']);
    }

    // Supprimer une arme
    #[Route('/api/weapons/{id}', name: 'api_delete_weapon', methods: ['DELETE'])]
    public function deleteWeapon($id, EntityManagerInterface $em): JsonResponse
    {
        $weapon = $em->getRepository(Weapon::class)->find($id);
        if (!$weapon) {
            return $this->json(['error' => 'Weapon not found'], 404);
        }
        $em->remove($weapon);
        $em->flush();
        return $this->json(['message' => 'Weapon deleted']);
    }
}
