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
        $aliveEnemies = $enemies->count();
        while($aliveEnemies>0)
        {
            $aliveEnemies = $enemies->count();

            $playerShip->TakeAction($cli,$enemies);

            for ($i = 0; $i < $enemies->count(); $i++)
            {
                if($enemies->get($i)->getHullIntegrity() <= 0)
                {
                    $aliveEnemies--;
                }
                if($enemies->get($i)->getHullIntegrity() > 0)
                {
                    $enemies->get($i)->enemyAttacksPlayer($playerShip,$cli);
                    $cli->info("Current Ship stats:");
                    $cli->out("Shields:".$playerShip->getShields());
                    $cli->out("Hull Integrity:".$playerShip->getHullIntegrity());
                }
            }
            if($playerShip->getHullIntegrity() <= 0)
            {
                $cli->info("Defeat! Your ship has been destroyed. Your journey has come to an end...");
                exit(0);
            }
            if ($aliveEnemies == 0)
            {
                $cli->info("Victory! Combat finished.");
                break;
            }
        }
    }




}