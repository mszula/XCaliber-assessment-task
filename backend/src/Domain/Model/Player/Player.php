<?php

declare(strict_types=1);

namespace App\Domain\Model\Player;

use App\Domain\Model\BonusWallet\BonusWallet;
use App\Domain\Model\Player\ValueObject\Age;
use App\Domain\Model\Player\ValueObject\Gender;
use App\Domain\Model\Player\ValueObject\LastName;
use App\Domain\Model\Player\ValueObject\Name;
use App\Domain\Model\Player\ValueObject\Password;
use App\Domain\Model\Player\ValueObject\Username;
use App\Domain\Model\Wallet\Wallet;
use App\Domain\Shared\Model\Uuid;

class Player
{
    /** @var Uuid */
    private $id;

    /** @var Username */
    private $username;

    /** @var Password */
    private $password;

    /** @var Name */
    private $name;

    /** @var LastName */
    private $lastName;

    /** @var Age */
    private $age;

    /** @var Gender */
    private $gender;

    /** @var Wallet */
    private $realMoneyWallet;

    public function __construct(
        Uuid $id,
        Username $username,
        Password $password,
        Name $name,
        LastName $lastName,
        Age $age,
        Gender $gender
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->gender = $gender;
    }

    public static function createFromPrimitiveTypes(
        string $uuid,
        string $username,
        string $password,
        string $name,
        string $lastName,
        int $age,
        string $gender
    ): self
    {
        return new self(
            new Uuid($uuid),
            new Username($username),
            new Password($password),
            new Name($name,),
            new LastName($lastName),
            new Age($age),
            new Gender($gender)
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function getAge(): Age
    {
        return $this->age;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getRealMoneyWallet(): Wallet
    {
        return $this->realMoneyWallet;
    }

    public function __toString(): string
    {
        return \sprintf('%s %s', $this->getName()->getValue(), $this->getLastName()->getValue());
    }
}