<?php

namespace App\Game;

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
     * @return TurnResult
     */
    public function playerTurn(): TurnResult
    {
        $bee = $this->attackService->playerAttacksBees($this->player, $this->hive);

        if ($bee === null) {
            return new TurnResult(false, null);
        }

        return new TurnResult(true, $bee, $bee->stingDamage());
    }

    /**
     * Bees take their turn to attack the player.
     *
     * @return TurnResult
     */
    public function beesTurn(): TurnResult
    {
        $bee = $this->attackService->beeAttacksPlayer($this->player, $this->hive);

        if ($bee === null) {
            return new TurnResult(false, null);
        }

        return new TurnResult(true, $bee, $bee->stingDamage());
    }
}
