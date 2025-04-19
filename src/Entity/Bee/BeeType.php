<?php

namespace App\Entity\Bee;

enum BeeType: string
{
    case Queen = 'queen';
    case Worker = 'worker';
    case Drone = 'drone';
}
