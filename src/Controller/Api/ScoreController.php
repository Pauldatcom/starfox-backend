<?php

namespace App\Controller\Api;

use App\Entity\GameSession;
use App\Entity\Player;
use App\Entity\Level;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    #[Route('/api/scores', name: 'api_add_score', methods: ['POST'])]
    public function addScore(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérification des champs reçus
        if (!isset($data['playerId'], $data['score'], $data['level'], $data['startedAt'], $data['endedAt'])) {
            return $this->json(['error' => 'Données incomplètes'], 400);
        }

        // Récupérer le joueur associé
        $player = $em->getRepository(Player::class)->find($data['playerId']);
        if (!$player) {
            return $this->json(['error' => 'Joueur non trouvé'], 404);
        }

        $gameSession = new GameSession();
        $gameSession->setPlayer($player);
        $gameSession->setScore($data['score']);
        $gameSession->setLevel($data['level']);
        $gameSession->setStartedAt(new \DateTimeImmutable($data['startedAt']));
        $gameSession->setEndedAt(new \DateTimeImmutable($data['endedAt']));

        $em->persist($gameSession);
        $em->flush();

        return $this->json(['success' => true, 'gameSessionId' => $gameSession->getId()]);
    }

    #[Route('/api/scores', name: 'api_list_scores', methods: ['GET'])]
    public function listScores(EntityManagerInterface $em): JsonResponse
    {
        $sessions = $em->getRepository(GameSession::class)->findBy([], ['score' => 'DESC'], 20);

        $data = [];
        foreach ($sessions as $session) {
            $data[] = [
                'id' => $session->getId(),
                'player' => $session->getPlayer()->getUsername(),
                'score' => $session->getScore(),
                'level' => $session->getLevel(),
                'startedAt' => $session->getStartedAt()->format('Y-m-d H:i:s'),
                'endedAt' => $session->getEndedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return $this->json($data);
    }
}
