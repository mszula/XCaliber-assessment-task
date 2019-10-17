<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Domain\Shared\Model\Uuid;
use App\ReadModel\Model\Wallet\WalletReadModelRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WalletsInfoController extends BaseController
{
    /**
     * @Route("/wallets/{playerId}", name="wallets", methods={"GET"})
     *
     * @param string $playerId
     * @param WalletReadModelRepositoryInterface $walletReadModelRepository
     * @return JsonResponse
     * @throws \App\Domain\Shared\Model\Exception\InvalidUuid
     */
    public function spin(
        string $playerId,
        WalletReadModelRepositoryInterface $walletReadModelRepository
    ): JsonResponse
    {
        $walletsInfo = $walletReadModelRepository->getWalletsInfo(new Uuid($playerId));

        return $this->json($walletsInfo, Response::HTTP_OK);
    }
}