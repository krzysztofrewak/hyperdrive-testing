<?php

declare(strict_types=1);

namespace Hyperdrive\Events;

use Hyperdrive\Geography\Planet;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Quest\Cargo;
use Hyperdrive\Quest\Quest;
use Hyperdrive\Quest\QuestLog;
use League\CLImate\CLImate;

class Event
{

    public function randomEvents(Pilot $player,Ship $playerShip, Planet $planet,QuestLog $questlog, CLImate $cli): void
    {
        $random = rand(1,10);

        if($random == 7)
        {
            $questlog->addQuest(new Quest($questlog->getRandomCargo(),$planet,false));
        }
        if($random == 8)
        {
            //asteroids
        }
        if($random == 9)
        {
           //combat
        }
        if($random == 10)
        {
           //tax or combat
        }

    }


}