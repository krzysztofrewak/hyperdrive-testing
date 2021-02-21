<?php

declare(strict_types=1);

namespace Hyperdrive\Player;

use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Player\Capital\Capital;
use Hyperdrive\Player\Navigator\HyperdriveNavigator;
use Hyperdrive\Player\Pilot\Pilot;
use Hyperdrive\Player\Spaceship\Spaceship;
use JetBrains\PhpStorm\ArrayShape;

class Player
{
    protected Planet $targetPlanet;
    protected ?Planet $currentPlanet;

    public function __construct(
        protected Capital $capital,
        protected Pilot $pilot,
        protected Spaceship $spaceship,
        protected HyperdriveNavigator $hyperdriveNavigator
    )
    {
        $this->targetPlanet = $this->hyperdriveNavigator->getRandomPlanet();
        $this->currentPlanet = $this->hyperdriveNavigator->getRandomPlanet();
    }

    public function getTargetPlanet(): Planet
    {
        return $this->targetPlanet;
    }

    public function getCurrentPlanet(): ?Planet
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
        $this->hyperdriveNavigator->jumpTo($planet);
        $this->currentPlanet = $this->hyperdriveNavigator->getCurrentPlanet();
    }

    public function getSpaceshipData(): array
    {
        return $this->spaceship->getSpaceshipData();
    }

    #[ArrayShape([
        "name" => "string",
        "capital" => "int",
        "target planet" => "string",
        "current planet" => "string",
    ])]
    public function getPlayerData(): array
    {
        return [
            "name" => $this->pilot->__toString(),
            "capital" => $this->capital->getCapital(),
            "target planet" => $this->targetPlanet->__toString(),
            "current planet" => $this->currentPlanet->__toString(),
        ];
    }

    public function getMap(): array
    {
        return $this->hyperdriveNavigator->getMap();
    }
}
