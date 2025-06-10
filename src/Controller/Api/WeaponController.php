<?php

namespace App\Controller\Api;

use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WeaponController extends AbstractController
{
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
                'createdAt' => $weapon->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return $this->json($data);
    }
}
