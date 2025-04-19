<?php

namespace App\Game;

use App\Entity\Bee\BeeInterface;
use App\Entity\Hive;
use App\Entity\Player;

class AttackService implements AttackServiceInterface
{
    public function __construct(
        private readonly float $playerHitChance = 0.7,
        private readonly float $beeHitChance = 0.5
    ) {
    }

    /**
     * @param Player $player
     * @param Hive $hive
     * @return BeeInterface|null
     */
    public function playerAttacksBees(Player $player, Hive $hive): ?BeeInterface
    {
        // Check whether player should hit bee
        if (!$this->isHitSuccessful($this->playerHitChance)) {
            return null;
        }

        // if all bees are dead, there's no one to hit
        $bees = $hive->getAliveBees();
        if (empty($bees)) {
            return null;
        }

        // choose a bee at random and hit it
        $bee = $bees[array_rand($bees)];
        $bee->takeDamage($bee->stingDamage());

        // keep track of player's hits'
        $player->registerHit();

        // if queen is dead, kill all bees
        if (!$hive->getQueen()) {
            $hive->killAllBees();
        }

        return $bee;
    }

    /**
     * @param Player $player
     * @param Hive $hive
     * @return BeeInterface|null
     */
    public function beeAttacksPlayer(Player $player, Hive $hive): ?BeeInterface
    {
        // get all remaining bees
        $aliveBees = $hive->getAliveBees();

        // if all bees are dead, there's no one to use
        if (empty($aliveBees)) {
            return null;
        }

        // choose a random bee to use, if attack successful keep track of players' stings and lower health
        $randomBee = $aliveBees[array_rand($aliveBees)];
        if ($this->isHitSuccessful($this->beeHitChance)) {
            $player->takeDamage($randomBee->stingDamage());
            $player->registerSting();
        }

        return $randomBee;
    }

    /**
     * @param Player $player
     * @param Hive $hive
     * @param BeeInterface $bee
     * @return BeeInterface|null
     */
    public function attackWithBee(Player $player, Hive $hive, BeeInterface $bee): ?BeeInterface
    {
        $aliveBees = $hive->getAliveBees();
        if (empty($aliveBees)) {
            return null;
        }

        $player->takeDamage($bee->stingDamage());
        $player->registerSting();
        return $bee;
    }

    /**
     * Calculate whether the hit should be successful or not
     *
     * @param float $chance
     * @return bool
     */
    private function isHitSuccessful(float $chance): bool
    {
        return mt_rand(0, 99) / 100 <= $chance;
    }
}
