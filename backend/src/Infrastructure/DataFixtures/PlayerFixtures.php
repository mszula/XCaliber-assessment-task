<?php

namespace App\Infrastructure\DataFixtures;

use App\Domain\Model\Player\Player;
use App\Domain\Model\Player\ValueObject\Age;
use App\Domain\Model\Player\ValueObject\Gender;
use App\Domain\Model\Player\ValueObject\LastName;
use App\Domain\Model\Player\ValueObject\Name;
use App\Domain\Model\Player\ValueObject\Password;
use App\Domain\Model\Player\ValueObject\Username;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Service\Id\UuidGeneratorInterface;
use App\Domain\Shared\Model\CommonWallet\ValueObject\InitialValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PlayerFixtures extends Fixture
{
    private const PLAYERS = [
        ['marty', 'Marty', 'McFly', 16, Gender::MALE],
        ['emmett', 'Emmett', 'Brown', 70, Gender::MALE],
        ['lorraine', 'Lorraine', 'Baines', 35, Gender::FEMALE],
        ['biff', 'Biff', 'Tannen', 40, Gender::MALE],
    ];
    /** @var UuidGeneratorInterface */
    private $uuidGenerator;

    public function __construct(UuidGeneratorInterface $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::PLAYERS as $player) {
            $player = Player::createFromPrimitiveTypes(
                $this->uuidGenerator->generate()->getValue(),
                $player[0],
                'test',
                $player[1],
                $player[2],
                $player[3],
                $player[4]
            );

            $wallet = new Wallet(
                $this->uuidGenerator->generate(),
                new InitialValue(random_int(0, 100)),
                $player
            );
            $manager->persist($player);
            $manager->persist($wallet);
        }

        $manager->flush();
    }
}
