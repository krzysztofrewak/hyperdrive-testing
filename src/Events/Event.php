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

    public function randomEvents(Pilot $player,Ship $playerShip, Planet $currentPlanet,Planet $randomPlanet,QuestLog $questlog, CLImate $cli): void
    {
        $random = rand(1,10);

        if($random == 7)
        {
            //story
            $questlog->addQuest(new Quest(cargo: $questlog->getRandomCargo(), destination: $randomPlanet, completed: false, main: false, exp: 2500, reward: $questlog->generateReward()));
        }
        if($random == 8)
        {
            //oh no asteroids
            $fuelLost = 5 * (10 - $player->getSkill());
            $playerShip->loseFuel($fuelLost);
        }
        if($random == 9)
        {
            //oh no you've been attacked
           $enemies = new Enemies();
           $combat = new Combat();
           $combat->landingOrFighting($player,$playerShip,$enemies->getEnemyShips(),$cli,$currentPlanet);
        }
        if($random == 10)
        {
           //greater events
        }

    }


}