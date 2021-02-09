<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\Geography\Planet;
use Hyperdrive\Ship\Ship;

class HyperdriveNavigator
{
    protected GalaxyAtlas $atlas;
    protected ?Planet $currentPlanet;

    public function __construct(GalaxyAtlas $atlas)
    {
        $this->atlas = $atlas;
    }

    public function getCurrentPlanet(): Planet
    {
        return $this->currentPlanet;
    }

    public function jumpTo(Ship $playerShip,Planet $planet): void
    {
        $this->currentPlanet = $planet;
        $playerShip->loseFuel(5);
        $playerShip->checkFuel();
    }

    public function getRandomPlanet(): Planet
    {
        $this->currentPlanet = $this->atlas->getRandomPlanet();
        return $this->currentPlanet;
    }
}
