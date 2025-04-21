<?php

namespace App\Tests\Game;

use App\Entity\Bee\BeeInterface;
use App\Entity\Bee\BeeType;
use App\Entity\Hive;
use App\Entity\Player;
use App\Game\NarratorService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class NarratorServiceTest extends TestCase
{
    private NarratorService $narrator;
    private BeeInterface $bee;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->narrator = new NarratorService();

        $this->bee = $this->createMock(BeeInterface::class);
        $this->bee
            ->method('getType')
            ->willReturn(BeeType::Queen);
        $this->bee->method('stingDamage')
            ->willReturn(10);
    }

    public function testPlayerHitReturnsMessage(): void
    {
        $message = $this->narrator->playerHit($this->bee);

        $this->assertIsString($message);
        $this->assertStringContainsString('queen', $message);
    }

    public function testPlayerMissReturnsMessage(): void
    {
        $message = $this->narrator->playerMiss();

        $this->assertIsString($message);
        $this->assertNotEmpty($message);
    }

    public function testBeeHitReturnsMessage(): void
    {
        $message = $this->narrator->beeHit($this->bee);

        $this->assertIsString($message);
        $this->assertStringContainsString('queen', $message);
    }

    /**
     * @throws Exception
     */
    public function testGameOverReturnsExpectedMessage(): void
    {
        $player = $this->createMock(Player::class);
        $hive = $this->createMock(Hive::class);

        $player->method('getHits')->willReturn(5);
        $player->method('getStings')->willReturn(3);
        $player->method('isAlive')->willReturn(true);

        $hive->method('getAliveBees')->willReturn([]);

        $message = $this->narrator->gameOver($player, $hive);

        $this->assertIsString($message);
        $this->assertStringContainsString('--- GAME OVER ---', $message);
        $this->assertStringContainsString('Hits dealt: 5', $message);
        $this->assertStringContainsString('Stings taken: 3', $message);
        $this->assertStringContainsString('No bees remain!', $message);
        $this->assertStringContainsString('You survived!', $message);
    }

    /**
     * @throws Exception
     */
    public function testGameOverWithAliveBees(): void
    {
        $player = $this->createMock(Player::class);
        $hive = $this->createMock(Hive::class);

        $player->method('getHits')->willReturn(7);
        $player->method('getStings')->willReturn(4);
        $player->method('isAlive')->willReturn(false);

        $bee = $this->createMock(BeeInterface::class);
        $bee->method('getType')->willReturn(BeeType::Worker);

        $hive->method('getAliveBees')->willReturn([$bee, $bee]);

        $message = $this->narrator->gameOver($player, $hive);

        $this->assertIsString($message);
        $this->assertStringContainsString('2 Worker Bees remaining', $message);
        $this->assertStringContainsString('You died!', $message);
    }


    public function testBeeMissReturnsMessage(): void
    {
        $message = $this->narrator->beeMiss($this->bee);

        $this->assertIsString($message);
        $this->assertStringContainsString('queen', $message);
    }
}
