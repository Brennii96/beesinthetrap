<?php

namespace App\Tests\Game;

use App\Entity\Hive;
use App\Entity\Player;
use App\Entity\Bee\BeeInterface;
use App\Entity\Bee\BeeType;
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

        $this->assertSame('You missed!', $result);
    }

    /**
     * @throws Exception
     */
    public function testPlayerTurnHitsBee(): void
    {
        $bee = $this->createMock(BeeInterface::class);
        $bee->method('getType')->willReturn(BeeType::Worker);

        $this->attackService->method('playerAttacksBees')->willReturn($bee);

        $result = $this->gameEngine->playerTurn();

        $this->assertSame('You hit a Worker bee!', $result);
    }

    /**
     * @throws Exception
     */
    public function testBeesTurn(): void
    {
        $bee = $this->createMock(BeeInterface::class);

        $this->attackService->method('beeAttacksPlayer')->willReturn($bee);

        $result = $this->gameEngine->beesTurn();

        $this->assertSame($bee, $result);
    }
}
