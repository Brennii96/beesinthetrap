<?php

namespace App\Entity\Bee;

class DroneBee extends AbstractBee
{
    public function __construct()
    {
        parent::__construct(60, BeeType::Drone);
    }

    /**
     * @return void
     */
    public function hit(): void
    {
        $this->hp = max(0, $this->hp - 30);
    }

    /**
     * @return int
     */
    public function stingDamage(): int
    {
        return 1;
    }
}
