<?php

namespace App\Entity\Bee;

interface BeeInterface
{
    public function getType(): BeeType;

    public function getHp(): int;

    public function takeDamage(int $damage): void;

    public function isAlive(): bool;

    public function stingDamage(): int;
}
