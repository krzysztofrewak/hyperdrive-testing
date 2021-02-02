<?php

declare(strict_types=1);

namespace Hyperdrive\Combat;

use Hyperdrive\Ship\Ship;
use Illuminate\Support\Collection;

class Combat
{

    public function fight(Ship $playerShip,Collection $enemies): void
    {
        $playerShip->TakeAction();

        for ($i = 0; $i < $enemies->count(); $i++)
        {
            $enemies->get($i)->enemyAttacksPlayer($playerShip);
        }
    }




}