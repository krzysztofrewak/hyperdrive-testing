<?php

declare(strict_types=1);

namespace Hyperdrive\Combat;

use Hyperdrive\Ship\Ship;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;

class Combat
{

    public function fight(Ship $playerShip,Collection $enemies,CLImate $cli): void
    {
        $playerShip->TakeAction($cli,$enemies);

        for ($i = 0; $i < $enemies->count(); $i++)
        {
            $enemies->get($i)->enemyAttacksPlayer($playerShip);
        }
    }




}