<?php

namespace App\Game;

use App\Entity\Bee\BeeInterface;

class TurnResult
{
    public function __construct(
        public readonly bool $hit,
        public readonly ?BeeInterface $bee,
        public readonly int $damage = 0
    ) {
    }
}
