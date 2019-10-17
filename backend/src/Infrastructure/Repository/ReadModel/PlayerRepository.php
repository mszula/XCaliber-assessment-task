<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\ReadModel;

use App\Domain\Model\Player\Player;
use App\Domain\Shared\Model\Uuid;
use App\ReadModel\Model\Player\Exception\PlayerNotFound;
use App\ReadModel\Model\Player\PlayerReadModelRepositoryInterface;
use App\ReadModel\Model\Player\ViewModel\PlayersList;
use App\ReadModel\Model\Player\ViewModel\ViewPlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PlayerRepository extends ServiceEntityRepository implements PlayerReadModelRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Player::class);
    }

    /**
     * @throws PlayerNotFound
     */
    public function getById(Uuid $uuid): Player
    {
        $player = $this->find($uuid->getValue());

        if (!$player instanceof Player) {
            throw PlayerNotFound::notFound($uuid->getValue());
        }

        return $player;
    }

    public function listPlayers(): PlayersList
    {
        $players = $this->findAll();

        $viewPlayers = [];
        /** @var Player $player */
        foreach ($players as $player) {
            $viewPlayers[] = new ViewPlayer($player->getId()->getValue(), (string)$player);
        }

        return new PlayersList(...$viewPlayers);
    }
}