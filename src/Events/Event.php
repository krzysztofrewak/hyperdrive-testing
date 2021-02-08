<?php

declare(strict_types=1);

namespace Hyperdrive\Events;

use Hyperdrive\Combat\Combat;
use Hyperdrive\Combat\Enemies;
use Hyperdrive\Geography\Planet;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Quest\Cargo;
use Hyperdrive\Quest\Quest;
use Hyperdrive\Quest\QuestLog;
use Hyperdrive\Ship\Ship;
use League\CLImate\CLImate;

class Event
{

    public function randomEvents(Pilot $player,Ship $playerShip, Planet $planet,QuestLog $questlog, CLImate $cli): void
    {
        $random = rand(1,10);

        if($random == 7)
        {
            //story
            $questlog->addQuest(new Quest($questlog->getRandomCargo(),$planet,false));
        }
        if($random == 8)
        {
            //oh no asteroids
            $fuel_loss = 30 - (5 * $player->getSkill());
            $playerShip->setFuel($playerShip->getFuel()-$fuel_loss);
        }
        if($random == 9)
        {
            //oh no you've been attacked
           $enemies = new Enemies();
           $combat = new Combat();
           $combat->fight($playerShip,$enemies->getEnemies(),$cli);
        }
        if($random == 10)
        {
           //greater events
        }

    }


}