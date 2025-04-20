<?php

namespace App\DTO;

use App\Entity\Bee\BeeInterface;

readonly class TurnResult
{
    public function __construct(
        public bool $hit,
        public ?BeeInterface $bee,
        public int $damage = 0
    ) {
    }
}
