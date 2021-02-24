<?php

declare(strict_types=1);

namespace Hyperdrive\Events;

use Hyperdrive\Combat\Combat;
use Hyperdrive\Combat\Enemies;
use Hyperdrive\Geography\Planet;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Output\OutputContract;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Quest\Cargo;
use Hyperdrive\Quest\Quest;
use Hyperdrive\Quest\QuestLog;
use Hyperdrive\Ship\Ship;
use League\CLImate\CLImate;

class Event
{
    protected OutputContract $output;

    /**
     * Event constructor.
     * @param OutputContract $output
     */
    public function __construct(OutputContract $output)
    {
        $this->output = $output;
    }


    public function randomSpaceEvents(Pilot $player,Ship $playerShip, Planet $currentPlanet,Planet $randomPlanet,QuestLog $questlog): void
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
            $this->output->info("You encountered an Asteroid belt! You lost some fuel while trying to maneuver through them.");
            $fuelLost = 5 * (10 - $player->getSkill());
            $playerShip->loseFuel($fuelLost);
        }
        if($random == 9)
        {
            $this->output->info("You've been attacked!");
            //oh no you've been attacked
            $enemies = new Enemies($this->output);
            $combat = new Combat($this->output);
            $combat->landingOrFighting($player,$playerShip,$enemies->getEnemyShips(),$currentPlanet);
        }
        if($random == 10)
        {
           //greater events
        }

    }

    public function randomLandEvents(Pilot $player,Ship $playerShip, Planet $currentPlanet,Planet $randomPlanet,QuestLog $questlog): void
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

        }
        if($random == 10)
        {

        }
        //fight
        //gambling
        //racing
        //some credits laying on the ground
    }


}