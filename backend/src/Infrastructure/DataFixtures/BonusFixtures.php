<?php

namespace App\Infrastructure\DataFixtures;

use App\Domain\Model\Bonus\Bonus;

use App\Domain\Model\Bonus\ValueObject\Name;
use App\Domain\Model\Bonus\ValueObject\RewardType;
use App\Domain\Model\Bonus\ValueObject\RewardValue;
use App\Domain\Model\Bonus\ValueObject\Trigger;
use App\Domain\Model\Bonus\ValueObject\WageringMultiplier;
use App\Domain\Service\Id\UuidGeneratorInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BonusFixtures extends Fixture
{
    /** @var UuidGeneratorInterface */
    private $uuidGenerator;

    public function __construct(UuidGeneratorInterface $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    public function load(ObjectManager $manager)
    {
        $bonus = new Bonus(
            $this->uuidGenerator->generate(),
            new Name('Login bonus'),
            new Trigger(Trigger::LOGIN),
            new RewardValue(5),
            new RewardType(RewardType::BONUS_MONEY),
            new WageringMultiplier(10),
        );
        $manager->persist($bonus);

        $bonus = new Bonus(
            $this->uuidGenerator->generate(),
            new Name('Deposit bonus'),
            new Trigger(Trigger::DEPOSIT),
            new RewardValue(50),
            new RewardType(RewardType::PERCENT_OF_DEPOSIT),
            new WageringMultiplier(20),
        );
        $manager->persist($bonus);

        $manager->flush();
    }
}
