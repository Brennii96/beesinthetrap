<?php

namespace App\Game;

use App\Entity\Bee\BeeInterface;
use App\Entity\Hive;
use App\Entity\Player;

class GameEngine
{
    public function __construct(
        private Hive $hive,
        private Player $player,
        private AttackServiceInterface $attackService
    ) {
    }

    /**
     * The game is over when either the player or all bees are dead.
     *
     * @return bool
     */
    public function isOver(): bool
    {
        return !$this->player->isAlive() || !$this->hive->isAlive();
    }

    /**
     * Players turn to attack the bees.
     *
     * @return string
     */
    public function playerTurn(): string
    {
        $bee = $this->attackService->playerAttacksBees($this->player, $this->hive);

        if ($bee === null) {
            return 'You missed!';
        }

        return 'You hit a ' . ucfirst($bee->getType()->value) . ' bee!';
    }

    /**
     * Bees take their turn to attack the player.
     *
     * @return BeeInterface|null
     */
    public function beesTurn(): ?BeeInterface
    {
        return $this->attackService->beeAttacksPlayer($this->player, $this->hive);
    }
}
