<?php

namespace App\Controller\Api;

use App\Entity\ObstacleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ObstacleTypeController extends AbstractController
{
    #[Route('/api/obstacles', name: 'api_list_obstacles', methods: ['GET'])]
    public function listObstacles(EntityManagerInterface $em): JsonResponse
    {
        $obstacles = $em->getRepository(ObstacleType::class)->findAll();

        $data = [];
        foreach ($obstacles as $obs) {
            $data[] = [
                'id' => $obs->getId(),
                'name' => $obs->getName(),
                'shape' => $obs->getShape(),
                'dimensions' => $obs->getDimensions(),
                'createdAt' => $obs->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }



    // Find an obstacle by its ID

                #[Route('/api/obstacles/{id}', name: 'api_show_obstacle', methods: ['GET'])]
            public function showObstacle($id, EntityManagerInterface $em): JsonResponse
            {
                $obs = $em->getRepository(ObstacleType::class)->find($id);
                if (!$obs) {
                    return $this->json(['error' => 'ObstacleType not found'], 404);
                }
                $data = [
                    'id' => $obs->getId(),
                    'name' => $obs->getName(),
                    'shape' => $obs->getShape(),
                    'dimensions' => $obs->getDimensions(),
                    'createdAt' => $obs->getCreatedAt()?->format('Y-m-d H:i:s'),
                ];
                return $this->json($data);
            }


    // Create an obstacle



                

            #[Route('/api/obstacles', name: 'api_create_obstacle', methods: ['POST'])]
            public function createObstacle(Request $request, EntityManagerInterface $em): JsonResponse
            {
                $data = json_decode($request->getContent(), true);

                $obs = new ObstacleType();
                $obs->setName($data['name'] ?? '');
                $obs->setShape($data['shape'] ?? '');
                $obs->setDimensions($data['dimensions'] ?? '');
                $obs->setCreatedAt(new \DateTimeImmutable());

                $em->persist($obs);
                $em->flush();

                return $this->json(['message' => 'ObstacleType created', 'id' => $obs->getId()], 201);
            }




    // modify an obstacle

                #[Route('/api/obstacles/{id}', name: 'api_update_obstacle', methods: ['PUT'])]
        public function updateObstacle($id, Request $request, EntityManagerInterface $em): JsonResponse
        {
            $obs = $em->getRepository(ObstacleType::class)->find($id);
            if (!$obs) {
                return $this->json(['error' => 'ObstacleType not found'], 404);
            }
            $data = json_decode($request->getContent(), true);

            if (isset($data['name'])) $obs->setName($data['name']);
            if (isset($data['shape'])) $obs->setShape($data['shape']);
            if (isset($data['dimensions'])) $obs->setDimensions($data['dimensions']);

            $em->flush();
            return $this->json(['message' => 'ObstacleType updated']);
        }



    // Delete an obstacle




            #[Route('/api/obstacles/{id}', name: 'api_delete_obstacle', methods: ['DELETE'])]
            public function deleteObstacle($id, EntityManagerInterface $em): JsonResponse
            {
                $obs = $em->getRepository(ObstacleType::class)->find($id);
                if (!$obs) {
                    return $this->json(['error' => 'ObstacleType not found'], 404);
                }
                $em->remove($obs);
                $em->flush();
                return $this->json(['message' => 'ObstacleType deleted']);
            }


}
