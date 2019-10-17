<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\ReadModel\Model\Player\PlayerReadModelRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayersListController extends BaseController
{
    /**
     * @Route("/players", name="players", methods={"GET"})
     *
     * @param PlayerReadModelRepositoryInterface $playerReadModelRepository
     * @return JsonResponse
     */
    public function playersList(
        PlayerReadModelRepositoryInterface $playerReadModelRepository
    ): JsonResponse
    {
        return $this->json($playerReadModelRepository->listPlayers(), Response::HTTP_OK);
    }
}