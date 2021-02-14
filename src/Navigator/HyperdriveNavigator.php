<?php

declare(strict_types=1);

namespace Hyperdrive\Navigator;

use Hyperdrive\GalaxyAtlas\GalaxyAtlas;
use Hyperdrive\Geography\Planet;

class HyperdriveNavigator
{
    protected ?Planet $currentPlanet;

    public function __construct(protected GalaxyAtlas $atlas)
    {
    }

    public function getCurrentPlanet(): Planet
    {
        return $this->currentPlanet;
    }

    public function jumpTo(Planet $planet): void
    {
        $this->currentPlanet = $planet;
    }

    public function getRandomPlanet(): Planet
    {
        $this->currentPlanet = $this->atlas->getRandomPlanet();
        return $this->currentPlanet;
    }
}
