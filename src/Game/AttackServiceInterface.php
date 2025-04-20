<?php

namespace App\Game;

use App\DTO\BeeAttackResult;
use App\DTO\PlayerAttackResult;
use App\Entity\Bee\BeeInterface;
use App\Entity\Hive;
use App\Entity\Player;

interface AttackServiceInterface
{
    public function playerAttacksBees(Player $player, Hive $hive): PlayerAttackResult|null;

    public function beeAttacksPlayer(Player $player, Hive $hive): BeeAttackResult|null;

    public function attackWithBee(Player $player, Hive $hive, BeeInterface $bee);

}
