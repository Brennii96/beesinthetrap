<?php

namespace App\Game;

use App\Entity\Bee\BeeInterface;
use App\Entity\Hive;
use App\Entity\Player;

interface AttackServiceInterface
{
    public function playerAttacksBees(Player $player, Hive $hive): ?BeeInterface;

    public function beeAttacksPlayer(Player $player, Hive $hive): ?BeeInterface;

    public function attackWithBee(Player $player, Hive $hive, BeeInterface $bee);

}
