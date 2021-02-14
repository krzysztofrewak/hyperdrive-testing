<?php

declare(strict_types=1);

namespace Hyperdrive\Combat;

use Hyperdrive\Geography\Planet;
use Hyperdrive\Output\Output;
use Hyperdrive\Output\OutputContract;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Ship\Ship;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;

class Combat
{

    public function fight(Pilot $player,Ship $playerShip, Collection $enemies, CLImate $cli): void
    {
        $aliveEnemies = $enemies->count();

        while ($aliveEnemies > 0) {
            $aliveEnemies = $enemies->count();

            $playerShip->TakeAction($cli, $enemies);

            for ($i = 0; $i < $enemies->count(); $i++)
            {
                if ($enemies->get($i)->getHullIntegrity() <= 0) {
                    $aliveEnemies--;
                }
                if ($enemies->get($i)->getHullIntegrity() > 0) {
                    $enemies->get($i)->enemyAttacksPlayer($playerShip, $cli);
                    $cli->info("Current Ship stats:");
                    $cli->out("Shields:" . $playerShip->getShields());
                    $cli->out("Hull Integrity:" . $playerShip->getHullIntegrity());
                }
            }
            if ($playerShip->getHullIntegrity() <= 0) {
                $cli->info("Defeat! Your ship has been destroyed. Your journey has come to an end.");
                exit(0);
            }
            if ($aliveEnemies == 0) {
                $cli->info("Victory! Combat finished.");
                $playerShip->setShields($playerShip->getMaxShields());
                $exp = $enemies->count() * 1000;
                $player->earnXP($exp);
                break;
            }
        }
    }

    public function landingOrFighting(Pilot $player,Ship $playerShip,Collection $enemies,CLImate $cli,Planet $currentPlanet): void
    {
        $options = ["Land" => "I will try to escape combat and land on ".$currentPlanet->getName(), "Fight" => "I'm going to fight the enemy ships"];
        $result = $cli->radio("You have been spotted by enemy ships! What will you do?", $options)->prompt();

        if ($result === "Land")
        {
            //lose fuel, take damage, land on planet
            $fuelLost = 5 * (10 - $player->getSkill());
            $playerShip->loseFuel($fuelLost);

            for ($i = 0; $i < $enemies->count(); $i++)
            {
                $enemies->get($i)->enemyAttacksPlayer($playerShip, $cli);
                $cli->info("Current Ship stats:");
                $cli->out("Shields:" . $playerShip->getShields());
                $cli->out("Hull Integrity:" . $playerShip->getHullIntegrity());
            }
            //lost enemies and landed successfully
        }
        if ($result === "Fight")
        {
            $this->fight($player,$playerShip,$enemies,$cli);
        }
    }

}