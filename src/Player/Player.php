<?php

declare(strict_types=1);

namespace Hyperdrive\Player;

use Hyperdrive\Geography\Planet;
use Hyperdrive\Player\Capital\Capital;
use Hyperdrive\Player\Navigator\HyperdriveNavigator;
use Hyperdrive\Player\Pilot\Pilot;
use Hyperdrive\Player\Spaceship\Spaceship;
use JetBrains\PhpStorm\ArrayShape;

class Player
{
    protected Capital $capital;
    protected Planet $targetPlanet;
    protected Planet $currentPlanet;

    public function __construct(
        protected Pilot $pilot,
        protected Spaceship $spaceship,
        protected HyperdriveNavigator $navigator
    ) {
        $this->capital = new Capital(20000);
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

    public function isPlanetsEqual(): bool
    {
        return $this->currentPlanet === $this->targetPlanet;
    }

    public function refuelingSpaceship(): void
    {
        $this->spaceship->fullRefueling($this->capital);
    }

    public function jumpToPlanet(Planet $planet): void
    {
        $this->spaceship->fuelConsumption();
        $this->navigator->jumpTo($planet);
        $this->currentPlanet = $this->navigator->getCurrentPlanet();
    }

    #[ArrayShape([
        "name" => "string",
        "fuel" => "int",
        "capacity" => "int",
        "fuelConsumption" => "int",
    ])]
    public function getSpaceshipData(): array
    {
        return $this->spaceship->getSpaceshipData();
    }

    #[ArrayShape([
        "name" => "string",
        "capital" => "int",
    ])]
    public function getPlayerData(): array
    {
        return [
            "name" => $this->pilot,
            "capital" => $this->capital->getCapital(),
        ];
    }
}
