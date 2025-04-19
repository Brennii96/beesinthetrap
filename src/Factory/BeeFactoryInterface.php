<?php

namespace App\Factory;

use App\Entity\Bee\BeeInterface;

interface BeeFactoryInterface
{
    public function createQueen(): BeeInterface;

    public function createWorkers(int $count): array;

    public function createDrones(int $count): array;
}
