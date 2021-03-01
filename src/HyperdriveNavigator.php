<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\Geography\PlanetWithProperties;

class HyperdriveNavigator
{
    protected GalaxyAtlas $atlas;
    protected ?PlanetWithProperties $currentPlanet;

    public function __construct(GalaxyAtlas $atlas)
    {
        $this->atlas = $atlas;
    }

    public function getCurrentPlanet(): PlanetWithProperties
    {
        return $this->currentPlanet;
    }

    public function jumpTo(PlanetWithProperties $planet): void
    {
        $this->currentPlanet = $planet;
    }

    public function getRandomPlanet(): PlanetWithProperties
    {
        $this->currentPlanet = $this->atlas->getRandomPlanet();
        return $this->currentPlanet;
    }
}
