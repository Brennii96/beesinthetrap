<?php

namespace App\Entity;

class Player
{
    private int $hp = 100;
    private int $hits = 0;
    private int $stings = 0;

    public function takeDamage(int $damage): void
    {
        $this->hp = max(0, $this->hp - $damage);
    }

    public function registerHit(): void
    {
        $this->hits++;
    }

    public function registerSting(): void
    {
        $this->stings++;
    }

    public function isAlive(): bool
    {
        return $this->hp > 0;
    }

    public function getHp(): int
    {
        return $this->hp;
    }

    public function getHits(): int
    {
        return $this->hits;
    }

    public function getStings(): int
    {
        return $this->stings;
    }

    public function restoreHp(): void
    {
        $this->hp = 100;
    }
}
