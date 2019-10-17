<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Request\SpinRequest;
use App\Domain\API\Spin\SpinCommand;
use App\Domain\Shared\Model\Uuid;
use App\ReadModel\Model\Player\PlayerReadModelRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpinController extends BaseController
{
    /**
     * @Route("/spin/{playerId}", name="spin", methods={"POST"})
     *
     * @param string $playerId
     * @param SpinRequest $spinRequest
     * @param PlayerReadModelRepositoryInterface $playerRepository
     * @return JsonResponse
     * @throws \App\Application\Exception\ModelValidationException
     * @throws \App\Domain\Shared\Model\Exception\InvalidUuid
     */
    public function spin(
        string $playerId,
        SpinRequest $spinRequest,
        PlayerReadModelRepositoryInterface $playerRepository
    ): JsonResponse
    {
        $this->validateModel($spinRequest);

        $player = $playerRepository->getById(new Uuid($playerId));

        $command = new SpinCommand(
            $spinRequest->amount,
            $player
        );

        $this->handleCommand($command);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}