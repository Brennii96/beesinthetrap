<?php

namespace App\Entity;

use App\Factory\BeeFactoryInterface;

class Hive extends AbstractHive
{
    /**
     * @param BeeFactoryInterface $beeFactory
     */
    public function __construct(BeeFactoryInterface $beeFactory)
    {
        $this->bees = array_merge(
            [$beeFactory->createQueen()],
            $beeFactory->createWorkers(5),
            $beeFactory->createDrones(25)
        );
    }
}
