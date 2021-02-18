<?php

declare(strict_types=1);

namespace Hyperdrive\Player;

use Hyperdrive\Geography\Planet;
use Hyperdrive\Navigator\HyperdriveNavigator;
use Hyperdrive\Player\Capital\Capital;
use Hyperdrive\Player\Pilot\Pilot;
use Hyperdrive\Player\Spaceship\Spaceship;
use JetBrains\PhpStorm\ArrayShape;

class Player
{
    protected Pilot $pilot;
    protected Spaceship $spaceship;
    protected Capital $capital;
    protected Planet $targetPlanet;
    protected Planet $currentPlanet;
    protected HyperdriveNavigator $navigator;

    public function __construct(Pilot $pilot, Spaceship $spaceship, HyperdriveNavigator $navigator)
    {
        $this->pilot = $pilot;
        $this->navigator = $navigator;
        $this->spaceship = $spaceship;
        $this->capital = new Capital(2000);
        $this->targetPlanet = $this->navigator->getRandomPlanet();
        $this->currentPlanet = $this->navigator->getRandomPlanet();
    }

    public function getTargetPlanet(): Planet
    {
        return $this->targetPlanet;
    }

    public function getCurrentPlanet(): Planet
    {
        return $this->currentPlanet;
    }

    public function checkPlanetsEquals(): bool
    {
        return $this->currentPlanet === $this->targetPlanet;
    }

    public function jumpToPlanet(Planet $planet): void
    {
        $this->spaceship->fuelConsumption();
        $this->navigator->jumpTo($planet);
        $this->currentPlanet = $this->navigator->getCurrentPlanet();
    }

    public function refuelingSpaceship(): void
    {
        $this->spaceship->fullRefueling($this->capital);
    }

    #[ArrayShape([
        "name" => "string",
        "fuel" => "int",
        "capacity" => "int",
        "fuelConsumption" => "int",
    ])]
    public function showSpaceshipData(): array
    {
        return $this->spaceship->getSpaceshipData();
    }

    #[ArrayShape([
        "name" => "string",
        "capital" => "int",
    ])]
    public function showPlayerData(): array
    {
        return [
            "name" => $this->pilot,
            "capital" => $this->capital->getCapital(),
        ];
    }
}
