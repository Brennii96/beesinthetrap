<?php

namespace App\Tests\Game;

use App\Entity\Bee\BeeType;
use App\Entity\Hive;
use App\Entity\Player;
use App\Factory\BeeFactory;
use App\Game\AttackService;
use PHPUnit\Framework\TestCase;

class AttackServiceTest extends TestCase
{
    public function testQueenBeeDamageCalculation()
    {
        // Set up Player and Hive
        $player = new Player();
        $hive = new Hive(new BeeFactory());
        $attackService = new AttackService();

        // Save original HP for comparison
        $originalHp = $player->getHp();

        // Test for Queen Bee
        $queenBee = $hive->getQueen();
        $this->assertEquals(10, $queenBee->stingDamage(), 'Queen Bee should deal 10 damage.');
        $attackService->attackWithBee($player, $hive, $queenBee);
        $this->assertEquals($originalHp - 10, $player->getHp(), 'Queen Bee should deal 10 damage.');
    }

    public function testWorkerBeeDamageCalculation()
    {
        // Set up Player and Hive
        $player = new Player();
        $hive = new Hive(new BeeFactory());
        $attackService = new AttackService();
        $originalHp = $player->getHp();
        $workerBee = $hive->getBeeOfType(BeeType::Worker);
        $this->assertEquals(5, $workerBee->stingDamage(), 'Worker Bee should deal 5 damage.');
        $attackService->attackWithBee($player, $hive, $workerBee);
        $this->assertEquals($originalHp - 5, $player->getHp(), 'Worker Bee should deal 5 damage.');
    }

    public function testDroneBeeDamageCalculation()
    {
        // Set up Player and Hive
        $player = new Player();
        $hive = new Hive(new BeeFactory());
        $attackService = new AttackService();
        $originalHp = $player->getHp();
        $droneBee = $hive->getBeeOfType(BeeType::Drone);
        $this->assertEquals(1, $droneBee->stingDamage(), 'Drone Bee should deal 1 damage.');
        $attackService->attackWithBee($player, $hive, $droneBee);
        $this->assertEquals($originalHp - 1, $player->getHp(), 'Drone Bee should deal 1 damage.');
    }
}
