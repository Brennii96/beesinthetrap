<?php

namespace App\Tests\Game;

use App\DTO\BeeAttackResult;
use App\DTO\TurnResult;
use App\Entity\Bee\BeeInterface;
use App\Entity\Bee\BeeType;
use App\Entity\Hive;
use App\Entity\Player;
use App\Game\AttackServiceInterface;
use App\Game\GameEngine;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class GameEngineTest extends TestCase
{
    private $hive;
    private $player;
    private $attackService;
    private $gameEngine;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->hive = $this->createMock(Hive::class);
        $this->player = $this->createMock(Player::class);
        $this->attackService = $this->createMock(AttackServiceInterface::class);

        $this->gameEngine = new GameEngine($this->hive, $this->player, $this->attackService);
    }

    public function testIsOverWhenPlayerDead(): void
    {
        $this->player->method('isAlive')->willReturn(false);
        $this->hive->method('isAlive')->willReturn(true);

        $this->assertTrue($this->gameEngine->isOver());
    }

    public function testIsOverWhenHiveDead(): void
    {
        $this->player->method('isAlive')->willReturn(true);
        $this->hive->method('isAlive')->willReturn(false);

        $this->assertTrue($this->gameEngine->isOver());
    }

    public function testIsOverWhenBothAlive(): void
    {
        $this->player->method('isAlive')->willReturn(true);
        $this->hive->method('isAlive')->willReturn(true);

        $this->assertFalse($this->gameEngine->isOver());
    }

    public function testPlayerTurnMisses(): void
    {
        $this->attackService->method('playerAttacksBees')->willReturn(null);

        $result = $this->gameEngine->playerTurn();

        $this->assertInstanceOf(TurnResult::class, $result);
        $this->assertFalse($result->hit);
        $this->assertNull($result->bee);
    }

    /**
     * @throws Exception
     */
    public function testPlayerTurnHitsBee(): void
    {
        $bee = $this->createMock(BeeInterface::class);
        $bee->method('getType')->willReturn(BeeType::Worker);
        $bee->method('stingDamage')->willReturn(10);

        $this->attackService->method('playerAttacksBees')->willReturn(
            new \App\DTO\PlayerAttackResult($bee, true, 10)  // <- return a PlayerAttackResult, not just the bee
        );

        $result = $this->gameEngine->playerTurn();

        $this->assertInstanceOf(TurnResult::class, $result);
        $this->assertTrue($result->hit);
        $this->assertSame($bee, $result->bee);
        $this->assertSame(10, $result->damage);
    }

    public function testBeesTurnMisses(): void
    {
        $this->attackService->method('beeAttacksPlayer')->willReturn(null);

        $result = $this->gameEngine->beesTurn();

        $this->assertInstanceOf(TurnResult::class, $result);
        $this->assertFalse($result->hit);
        $this->assertNull($result->bee);
    }

    /**
     * @throws Exception
     */
    public function testBeesTurnHitsPlayer(): void
    {
        $bee = $this->createMock(BeeInterface::class);
        $bee->method('stingDamage')->willReturn(5);

        $this->attackService->method('beeAttacksPlayer')->willReturn(
            new BeeAttackResult($bee, true)
        );

        $result = $this->gameEngine->beesTurn();

        $this->assertInstanceOf(TurnResult::class, $result);
        $this->assertTrue($result->hit);
        $this->assertSame($bee, $result->bee);
        $this->assertSame(5, $result->damage);
    }
}
