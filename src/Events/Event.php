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

    public function randomSpaceEvents(Pilot $player,Ship $playerShip, Planet $currentPlanet,Planet $randomPlanet,QuestLog $questlog, CLImate $cli): void
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
            $cli->info("You encountered an Asteroid belt! You lost some fuel while trying to maneuver through them.");
            $fuelLost = 5 * (10 - $player->getSkill());
            $playerShip->loseFuel($fuelLost);
        }
        if($random == 9)
        {
            $cli->info("You've been attacked!");
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

    public function randomLandEvents(Pilot $player,Ship $playerShip, Planet $currentPlanet,Planet $randomPlanet,QuestLog $questlog, CLImate $cli): void
    {
        $random = rand(1,10);

        if($random == 7)
        {
            //fight
        }
        if($random == 8)
        {

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
        //fight
        //gambling
        //racing
        //some credits laying on the ground
    }


}