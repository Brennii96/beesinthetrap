<?php

namespace App\Entity\Bee;

class QueenBee extends AbstractBee
{
    public function __construct()
    {
        parent::__construct(100, BeeType::Queen);
    }

    /**
     * @return void
     */
    public function hit(): void
    {
        $this->hp = max(0, $this->hp - 10);
    }

    /**
     * @return int
     */
    public function stingDamage(): int
    {
        return 10;
    }
}
