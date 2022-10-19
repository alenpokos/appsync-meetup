<?php

namespace App\Controller;

use App\Service\AppSync;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerMoveActionController
{
    public function __construct(
        private readonly AppSync $appSync,
    )
    {
    }

    #[Route('/player-action', name: 'app_player_action', methods: ["POST"])]
    public function index(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        $this->appSync->playerAction(
            position: $payload['position'],
            player: $payload['player'],
            hitlog: $payload['hitlog']
        );

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
