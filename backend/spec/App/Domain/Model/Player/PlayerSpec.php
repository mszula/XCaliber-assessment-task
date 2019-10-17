<?php

namespace spec\App\Domain\Model\Player;

use App\Domain\Model\Player\Player;
use App\Domain\Model\Player\ValueObject\Age;
use App\Domain\Model\Player\ValueObject\Gender;
use App\Domain\Model\Player\ValueObject\LastName;
use App\Domain\Model\Player\ValueObject\Name;
use App\Domain\Model\Player\ValueObject\Password;
use App\Domain\Model\Player\ValueObject\Username;
use App\Domain\Shared\Model\Uuid;
use PhpSpec\ObjectBehavior;

class PlayerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(
            new Uuid('4dc97417-6da6-4ddf-9eda-b2f7f8d122df'),
            new Username('test'),
            new Password('test'),
            new Name('John'),
            new LastName('Doe'),
            new Age(20),
            new Gender('M')
        );
        $this->shouldHaveType(Player::class);
    }
}
