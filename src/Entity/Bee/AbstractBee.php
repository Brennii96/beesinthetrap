<?php

namespace App\Entity\Bee;

abstract class AbstractBee implements BeeInterface
{
    /**
     * @param int $hp
     * @param BeeType $type
     */
    public function __construct(protected int $hp, protected BeeType $type)
    {
    }

    /**
     * @return BeeType
     */
    public function getType(): BeeType
    {
        return $this->type;
    }

    /**
     * @param int $damage
     * @return void
     */
    public function takeDamage(int $damage): void
    {
        $this->hp -= $damage;
    }

    /**
     * @return bool
     */
    public function isAlive(): bool
    {
        return $this->hp > 0;
    }

    /**
     * @return int
     */
    public function getHp(): int
    {
        return $this->hp;
    }
}
