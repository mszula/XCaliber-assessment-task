<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

abstract class StringValueObject
{
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
