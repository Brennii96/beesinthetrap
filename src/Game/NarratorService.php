<?php

namespace App\Game;

use App\Entity\Bee\BeeInterface;

class NarratorService implements NarratorServiceInterface
{
    private array $playerHitMessages = [
        'Direct Hit! You hit a %s bee!',
        'Bullseye! You took %s down!'
    ];

    private array $playerMissMessages = [
        'Miss! You just missed the hive, better luck next time!',
        'Oops! You completely missed!',
        'Buzz! That was close but no hit!',
    ];

    private array $beeHitMessages = [
        'Sting! A %s bee stung you!',
        'Ouch! You got hit by a %s bee!'
    ];

    private array $beeMissMessages = [
        'Buzz! That was close! The %s bee missed!',
        'Safe! The %s bee couldn\'t land the sting!',
    ];

    public function playerHit(BeeInterface $bee): string
    {
        return sprintf($this->randomMessage($this->playerHitMessages), strtolower($bee->getType()->value));
    }

    public function playerMiss(): string
    {
        return $this->randomMessage($this->playerMissMessages);
    }

    public function beeHit(BeeInterface $bee): string
    {
        return sprintf($this->randomMessage($this->beeHitMessages), strtolower($bee->getType()->value));
    }

    public function beeMiss(BeeInterface $bee): string
    {
        return sprintf($this->randomMessage($this->beeMissMessages), strtolower($bee->getType()->value));
    }

    private function randomMessage(array $messages): string
    {
        return $messages[array_rand($messages)];
    }
}
