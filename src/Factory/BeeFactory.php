<?php

namespace App\Factory;

use App\Entity\Bee\BeeInterface;
use App\Entity\Bee\DroneBee;
use App\Entity\Bee\QueenBee;
use App\Entity\Bee\WorkerBee;

class BeeFactory implements BeeFactoryInterface
{
    /**
     * @return BeeInterface
     */
    public function createQueen(): BeeInterface
    {
        return new QueenBee();
    }

    /**
     * @param int $count
     * @return array
     */
    public function createWorkers(int $count = 5): array
    {
        return array_map(fn() => new WorkerBee(), range(1, $count));
    }

    /**
     * @param int $count
     * @return array
     */
    public function createDrones(int $count = 25): array
    {
        return array_map(fn() => new DroneBee(), range(1, $count));
    }
}
