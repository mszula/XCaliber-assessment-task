<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Request\MakeDepositRequest;
use App\Domain\API\MakeDeposit\MakeDepositCommand;
use App\Domain\API\SimulateLogin\SimulateLoginCommand;
use App\Domain\Shared\Model\Uuid;
use App\ReadModel\Model\Player\PlayerReadModelRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimulateLoginController extends BaseController
{
    /**
     * @Route("/simulate-login/{playerId}", name="simulate_login", methods={"POST"})
     *
     * @param string $playerId
     * @param PlayerReadModelRepositoryInterface $playerRepository
     * @return JsonResponse
     * @throws \App\Domain\Shared\Model\Exception\InvalidUuid
     */
    public function simulatedLogin(
        string $playerId,
        PlayerReadModelRepositoryInterface $playerRepository
    ): JsonResponse
    {
        $player = $playerRepository->getById(new Uuid($playerId));

        $command = new SimulateLoginCommand($player);

        $this->handleCommand($command);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}