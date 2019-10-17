<?php

declare(strict_types=1);

namespace App\ReadModel\Model\Player\ViewModel;

class PlayersList
{
    /** @var array|ViewPlayer[] */
    public $players;

    public function __construct(ViewPlayer ...$players)
    {
        $this->players = $players;
    }
}