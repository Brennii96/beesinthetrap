<?php

namespace App\Game;

use App\Entity\Bee\BeeInterface;
use App\Entity\Hive;
use App\Entity\Player;

interface NarratorServiceInterface
{
    public function statsAfterTurn(Player $player, Hive $hive): string;

    public function gameOver(Player $player, Hive $hive): string;

    public function playerInstruction(): string;

    public function invalidAction(): string;

    public function autoPlayMode(): string;

    public function beeHit(BeeInterface $bee): string;

    public function beesAttacking(): string;

    public function playerMiss(): string;

    public function beeMiss(BeeInterface $bee): string;

    public function playerHit(BeeInterface $bee): string;
}
