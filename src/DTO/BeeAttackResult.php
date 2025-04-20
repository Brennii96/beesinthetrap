<?php

namespace App\DTO;

use App\Entity\Bee\BeeInterface;

final readonly class BeeAttackResult
{
    public function __construct(
        public BeeInterface $bee,
        public bool $hit,
    ) {
    }
}
