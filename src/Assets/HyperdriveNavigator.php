<?php

declare(strict_types=1);

namespace Hyperdrive\Assets;

use Hyperdrive\Geography\Planet;

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
