<?php

namespace App\Entity\Bee;

class WorkerBee extends AbstractBee
{
    public function __construct()
    {
        parent::__construct(75, BeeType::Worker);
    }

    /**
     * @return void
     */
    public function hit(): void
    {
        $this->hp = max(0, $this->hp - 25);
    }

    /**
     * @return int
     */
    public function stingDamage(): int
    {
        return 5;
    }
}
