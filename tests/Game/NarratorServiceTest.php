<?php

namespace App\Tests\Game;

use App\Entity\Bee\BeeType;
use App\Game\NarratorService;
use App\Entity\Bee\BeeInterface;
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

    public function testBeeMissReturnsMessage(): void
    {
        $message = $this->narrator->beeMiss($this->bee);

        $this->assertIsString($message);
        $this->assertStringContainsString('queen', $message);
    }
}
