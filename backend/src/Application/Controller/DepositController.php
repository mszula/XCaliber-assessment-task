<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Request\MakeDepositRequest;
use App\Domain\API\MakeDeposit\MakeDepositCommand;
use App\Domain\Shared\Model\Uuid;
use App\ReadModel\Model\Player\PlayerReadModelRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepositController extends BaseController
{
    /**
     * @Route("/make-deposit/{playerId}", name="make_deposit", methods={"POST"})
     *
     * @param string $playerId
     * @param MakeDepositRequest $makeDepositRequest
     * @param PlayerReadModelRepositoryInterface $playerRepository
     * @return JsonResponse
     * @throws \App\Application\Exception\ModelValidationException
     * @throws \App\Domain\Shared\Model\Exception\InvalidUuid
     */
    public function makeDeposit(
        string $playerId,
        MakeDepositRequest $makeDepositRequest,
        PlayerReadModelRepositoryInterface $playerRepository
    ): JsonResponse
    {
        $this->validateModel($makeDepositRequest);

        $player = $playerRepository->getById(new Uuid($playerId));

        $command = new MakeDepositCommand(
            $makeDepositRequest->amount,
            $player
        );

        $this->handleCommand($command);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}