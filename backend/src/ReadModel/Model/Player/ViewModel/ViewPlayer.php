<?php

declare(strict_types=1);

namespace App\ReadModel\Model\Player\ViewModel;

class ViewPlayer
{
    /** @var string */
    public $id;

    /** @var string */
    public $fullName;

    public function __construct(string $id, string $fullName)
    {
        $this->id = $id;
        $this->fullName = $fullName;
    }
}