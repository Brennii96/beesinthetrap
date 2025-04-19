<?php

namespace App\Game;

use App\Entity\Bee\BeeInterface;

interface NarratorServiceInterface
{
    public function beeHit(BeeInterface $bee): string;

    public function playerMiss(): string;

    public function beeMiss(BeeInterface $bee): string;

    public function playerHit(BeeInterface $bee): string;
}
