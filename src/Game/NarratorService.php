<?php

namespace App\Game;

use App\Entity\Bee\BeeInterface;
use App\Entity\Hive;
use App\Entity\Player;

class NarratorService implements NarratorServiceInterface
{
    private array $playerHitMessages = [
        'Direct Hit! You hit a {type} bee!',
        'Bullseye! You took {type} down!'
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
        'Sting! A {type} bee stung you!',
        'Ouch! You got hit by a {type} bee!',
        'Direct Hit! You took {damage} from a {type} bee!'
    ];

    private array $beeMissMessages = [
        'Buzz! That was close! The {type} bee missed!',
        'Safe! The {type} bee couldn\'t land the sting!',
    ];

    /**
     * ASCII art generated using http://patorjk.com/software/taag/
     * @return string
     */
    public function gameIntro(): string
    {
        return <<<ASCII
______                  _         _   _            _                   
| ___ \                (_)       | | | |          | |                  
| |_/ / ___  ___  ___   _ _ __   | |_| |__   ___  | |_ _ __ __ _ _ __  
| ___ \/ _ \/ _ \/ __| | | '_ \  | __| '_ \ / _ \ | __| '__/ _` | '_ \ 
| |_/ /  __/  __/\__ \ | | | | | | |_| | | |  __/ | |_| | | (_| | |_) |
\____/ \___|\___||___/ |_|_| |_|  \__|_| |_|\___|  \__|_|  \__,_| .__/ 
                                                                | |    
                                                                |_|
ASCII;
    }

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
        $replace = [
            '{type}' => strtolower($bee->getType()->value),
        ];
        return $this->buildMessage($this->randomMessage($this->playerHitMessages), $replace);
    }

    public function playerMiss(): string
    {
        return $this->randomMessage($this->playerMissMessages);
    }

    public function beeHit(BeeInterface $bee): string
    {
        $replace = [
            '{type}' => strtolower($bee->getType()->value),
        ];
        return $this->buildMessage($this->randomMessage($this->beeHitMessages), $replace);
    }

    public function beeMiss(BeeInterface $bee): string
    {
        $replace = [
            '{type}' => strtolower($bee->getType()->value),
            '{damage}' => $bee->stingDamage()
        ];
        return $this->buildMessage($this->randomMessage($this->beeMissMessages), $replace);
    }

    private function buildMessage(string $message, array $replacements): string
    {
        if (empty($replacements)) {
            return $message;
        }
        return strtr($message, $replacements);
    }

    private function randomMessage(array $messages): string
    {
        if (empty($messages)) {
            throw new \RuntimeException('No messages available to choose from.');
        }
        return $messages[array_rand($messages)];
    }

    public function invalidAction(): string
    {
        return 'Invalid action.';
    }
}
