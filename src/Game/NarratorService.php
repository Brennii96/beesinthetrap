<?php

namespace App\Game;

use App\Entity\Bee\BeeInterface;
use App\Entity\Hive;
use App\Entity\Player;

class NarratorService implements NarratorServiceInterface
{
    private array $playerHitMessages = [
        'Direct Hit! You hit a %s bee!',
        'Bullseye! You took %s down!'
    ];

    private array $beesAttackingMessages = [
        'Bees preparing counter attack, prepare yourself!',
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

    public function gameOver(Player $player, Hive $hive): string
    {
        $lines = [];
        $lines[] = '--- GAME OVER ---';
        $lines[] = 'Hits dealt: ' . $player->getHits();
        $lines[] = 'Stings taken: ' . $player->getStings();

        $aliveBees = $hive->getAliveBees();
        if (count($aliveBees) > 0) {
            $grouped = [];
            foreach ($aliveBees as $bee) {
                $type = $bee->getType()->name;
                $grouped[$type] = ($grouped[$type] ?? 0) + 1;
            }

            foreach ($grouped as $type => $count) {
                $lines[] = "$count $type Bee" . ($count > 1 ? 's' : '') . ' remaining';
            }
        } else {
            $lines[] = 'No bees remain!';
        }

        $lines[] = $player->isAlive() ? '<positive>You survived!</positive>' : '<negative>You died!</negative>';

        return implode(PHP_EOL, $lines);
    }

    public function playerInstruction(): string
    {
        return 'Type "hit" to attack: ';
    }

    public function autoPlayMode(): string
    {
        return "Starting auto-play mode...";
    }

    public function beesAttacking(): string
    {
        return $this->randomMessage($this->beesAttackingMessages);
    }

    public function statsAfterTurn(Player $player, Hive $hive): string
    {
        $lines = [];
        $lines[] = 'Hits dealt: ' . $player->getHits();
        $lines[] = 'Stings taken: ' . $player->getStings();
        return implode(PHP_EOL, $lines);
    }

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

    public function invalidAction(): string
    {
        return 'Invalid action.';
    }
}
