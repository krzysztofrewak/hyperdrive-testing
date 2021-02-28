<?php

declare(strict_types=1);

namespace Hyperdrive\Combat;

use Hyperdrive\Events\Event;
use Hyperdrive\Geography\PlanetSurface;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Output\OutputContract;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Quest\QuestLog;
use Hyperdrive\Ship\Ship;
use Illuminate\Support\Collection;

class Combat
{
    protected OutputContract $output;


    public function __construct(OutputContract $output)
    {
        $this->output = $output;
    }

    public function fight(Pilot $player, Ship $playerShip, Collection $enemies): void
    {
        $aliveEnemies = $enemies->count();

        while ($aliveEnemies > 0) {
            $aliveEnemies = $enemies->count();

            $playerShip->TakeAction($enemies);

            for ($i = 0; $i < $enemies->count(); $i++) {
                if ($enemies->get($i)->getHullIntegrity() <= 0) {
                    $aliveEnemies--;
                }
                if ($enemies->get($i)->getHullIntegrity() > 0) {
                    $this->output->write("");
                    $enemies->get($i)->enemyAttacksPlayer($playerShip);
                    $this->output->info("Current Ship stats:");
                    $this->output->write("Shields:" . $playerShip->getShields());
                    $this->output->write("Hull Integrity:" . $playerShip->getHullIntegrity());
                }
            }
            if ($playerShip->getHullIntegrity() <= 0) {
                $this->output->write("");
                $this->output->info("Defeat! Your ship has been destroyed. Your journey has come to an end.");
                exit(0);
            }
            if ($aliveEnemies == 0) {
                $this->output->write("");
                $this->output->info("Victory! Combat finished.");
                $playerShip->setShields($playerShip->getMaxShields());
                $exp = $enemies->count() * 1000;
                $player->earnXP($exp);
                break;
            }
        }
    }

    public function landingOrFighting(Pilot $player, Ship $playerShip, Collection $enemies, PlanetSurface $surface, Event $event, QuestLog $questlog, HyperdriveNavigator $hyperdrive): void
    {
        $this->output->write("");
        $options = ["Land" => "I will try to escape combat and land on " . $hyperdrive->getCurrentPlanet()->getName(), "Fight" => "I'm going to fight the enemy ships"];
        $result = $this->output->getCli()->radio("You have been spotted by enemy ships! What will you do?", $options)->prompt();

        if ($result === "Land") {
            $this->output->write("");
            $this->output->write("You decided to escape to planet's surface. You lost some fuel while using thrusters.");
            $fuelLost = 5 * (10 - $player->getSkill());
            $playerShip->loseFuel($fuelLost);
            $this->output->write("While escaping you were attacked by enemy ships!");

            for ($i = 0; $i < $enemies->count(); $i++) {
                $this->output->write("");
                $enemies->get($i)->enemyAttacksPlayer($playerShip);
                $enemies->get($i)->enemyAttacksPlayer($playerShip);
                $this->output->write("");
                $this->output->info("Current Ship stats:");
                $this->output->write("Shields:" . $playerShip->getShields());
                $this->output->write("Hull Integrity:" . $playerShip->getHullIntegrity());
            }
            $playerShip->setShields($playerShip->getMaxShields());
            $event->randomLandEvents(player: $player, playerShip: $playerShip);
            $surface->whatToDo(player: $player, playerShip: $playerShip, hyperdrive: $hyperdrive, questlog: $questlog);

        }
        if ($result === "Fight") {
            $this->fight($player, $playerShip, $enemies);
        }
    }

}