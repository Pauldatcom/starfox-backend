<?php

namespace App\Controller\Api;

use App\Entity\ItemDefinition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ItemDefinitionController extends AbstractController
{
    #[Route('/api/items', name: 'api_list_items', methods: ['GET'])]
    public function listItems(EntityManagerInterface $em): JsonResponse
    {
        $items = $em->getRepository(ItemDefinition::class)->findAll();

        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'id' => $item->getId(),
                'itemKey' => $item->getItemKey(),
                'name' => $item->getName(),
                'effectType' => $item->getEffectType(),
                'effectValue' => $item->getEffectValue(),
                'iconPath' => $item->getIconPath(),
                'createdAt' => $item->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }
}
