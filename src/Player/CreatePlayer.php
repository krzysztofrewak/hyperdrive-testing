<?php

declare(strict_types=1);

namespace Hyperdrive\Player;

use Hyperdrive\Panels\StartPanel;
use Hyperdrive\Player\Capital\Capital;
use Hyperdrive\Player\Navigator\HyperdriveNavigator;

class CreatePlayer
{
    public static function create(): Player
    {
        $startPanel = new StartPanel();

        $level = $startPanel->selectDifficultyLevel();
        $pilot = $startPanel->selectPilot();
        $spaceship = $startPanel->selectSpaceship();
        $spaceship->setFuel($level->getFuel());
        $route = $startPanel->selectRoute();
        $capital = new Capital($level->getCapital());
        $hyperdriveNavigator = new HyperdriveNavigator($route, $level->getHyperspaceJumpsLimit());

        return new Player(
            $capital,
            $pilot,
            $spaceship,
            $hyperdriveNavigator,
        );
    }
}
