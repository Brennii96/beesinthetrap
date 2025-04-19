<?php

namespace App\Tests\Factory;

use App\Factory\BeeFactory;
use App\Entity\Bee\QueenBee;
use App\Entity\Bee\WorkerBee;
use App\Entity\Bee\DroneBee;
use PHPUnit\Framework\TestCase;

class BeeFactoryTest extends TestCase
{
    private BeeFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new BeeFactory();
    }

    public function testCreateQueen(): void
    {
        $queen = $this->factory->createQueen();
        $this->assertBeeProperties($queen, 100, 10, QueenBee::class);
    }

    public function testCreateWorkers(): void
    {
        $workers = $this->factory->createWorkers(5);
        $this->assertCount(5, $workers);
        foreach ($workers as $worker) {
            $this->assertBeeProperties($worker, 75, 5, WorkerBee::class);
        }
    }

    public function testCreateDrones(): void
    {
        $drones = $this->factory->createDrones(25);
        $this->assertCount(25, $drones);
        foreach ($drones as $drone) {
            $this->assertBeeProperties($drone, 60, 1, DroneBee::class);
        }
    }

    private function assertBeeProperties(
        object $bee,
        int $expectedHp,
        int $expectedStingDamage,
        string $expectedClass
    ): void {
        $this->assertEquals($expectedHp, $bee->getHp());
        $this->assertEquals($expectedStingDamage, $bee->stingDamage());
        $this->assertInstanceOf($expectedClass, $bee);
    }
}
