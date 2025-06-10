<?php

namespace App\Controller\Api;

use App\Entity\ItemDefinition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


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


    // See an item by its ID

                #[Route('/api/items/{id}', name: 'api_show_item', methods: ['GET'])]
            public function showItem($id, EntityManagerInterface $em): JsonResponse
            {
                $item = $em->getRepository(ItemDefinition::class)->find($id);
                if (!$item) {
                    return $this->json(['error' => 'ItemDefinition not found'], 404);
                }
                $data = [
                    'id' => $item->getId(),
                    'itemKey' => $item->getItemKey(),
                    'name' => $item->getName(),
                    'effectType' => $item->getEffectType(),
                    'effectValue' => $item->getEffectValue(),
                    'iconPath' => $item->getIconPath(),
                    'createdAt' => $item->getCreatedAt()?->format('Y-m-d H:i:s'),
                ];
                return $this->json($data);
            }


    // Create an item


            #[Route('/api/items', name: 'api_create_item', methods: ['POST'])]
            public function createItem(Request $request, EntityManagerInterface $em): JsonResponse
            {
                $data = json_decode($request->getContent(), true);

                $item = new ItemDefinition();
                $item->setItemKey($data['itemKey'] ?? '');
                $item->setName($data['name'] ?? '');
                $item->setEffectType($data['effectType'] ?? '');
                $item->setEffectValue($data['effectValue'] ?? 0);
                $item->setIconPath($data['iconPath'] ?? '');
                $item->setCreatedAt(new \DateTimeImmutable());

                $em->persist($item);
                $em->flush();

                return $this->json(['message' => 'ItemDefinition created', 'id' => $item->getId()], 201);
            }



    // Modify an item


                #[Route('/api/items/{id}', name: 'api_update_item', methods: ['PUT'])]
            public function updateItem($id, Request $request, EntityManagerInterface $em): JsonResponse
            {
                $item = $em->getRepository(ItemDefinition::class)->find($id);
                if (!$item) {
                    return $this->json(['error' => 'ItemDefinition not found'], 404);
                }
                $data = json_decode($request->getContent(), true);

                if (isset($data['itemKey'])) $item->setItemKey($data['itemKey']);
                if (isset($data['name'])) $item->setName($data['name']);
                if (isset($data['effectType'])) $item->setEffectType($data['effectType']);
                if (isset($data['effectValue'])) $item->setEffectValue($data['effectValue']);
                if (isset($data['iconPath'])) $item->setIconPath($data['iconPath']);

                $em->flush();
                return $this->json(['message' => 'ItemDefinition updated']);
            }



    // Delete an item

                #[Route('/api/items/{id}', name: 'api_delete_item', methods: ['DELETE'])]
                public function deleteItem($id, EntityManagerInterface $em): JsonResponse
                {
                    $item = $em->getRepository(ItemDefinition::class)->find($id);
                    if (!$item) {
                        return $this->json(['error' => 'ItemDefinition not found'], 404);
                    }
                    $em->remove($item);
                    $em->flush();
                    return $this->json(['message' => 'ItemDefinition deleted']);
                }

}
