<?php

namespace App\Entity;

use App\Entity\Bee\BeeInterface;
use App\Entity\Bee\BeeType;
use App\Entity\Bee\QueenBee;

abstract class AbstractHive
{
    /** @var BeeInterface[] */
    protected array $bees = [];

    /**
     * @return array
     */
    public function getAliveBees(): array
    {
        return array_filter($this->bees, fn(BeeInterface $bee) => $bee->isAlive());
    }

    /**
     * @return BeeInterface|null
     */
    public function getQueen(): ?BeeInterface
    {
        return array_find($this->bees, fn($bee) => $bee instanceof QueenBee);
    }

    /**
     * @param BeeType $beeType
     * @return BeeInterface|null
     */
    public function getBeeOfType(BeeType $beeType): ?BeeInterface
    {
        return array_find($this->bees, fn(BeeInterface $bee) => $bee->getType() === $beeType);
    }

    /**
     * @return bool
     */
    public function isAlive(): bool
    {
        return !empty($this->getAliveBees());
    }
}
