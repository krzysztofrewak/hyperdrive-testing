<?php

declare(strict_types=1);

namespace Hyperdrive\Player;

use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Player\Capital\Capital;
use Hyperdrive\Player\Navigator\HyperdriveNavigator;
use Hyperdrive\Player\Navigator\HyperspaceJump;
use Hyperdrive\Player\Pilot\Pilot;
use Hyperdrive\Player\Spaceship\Spaceship;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Config\Definition\Exception\Exception;

class Player
{
    protected Planet $targetPlanet;

    public function __construct(
        protected Capital $capital,
        protected Pilot $pilot,
        protected Spaceship $spaceship,
        protected HyperdriveNavigator $hyperdriveNavigator,
    )
    {
        $this->targetPlanet = $this->hyperdriveNavigator->getRandomPlanet();
        $this->hyperdriveNavigator->getRandomPlanet();
    }

    public function getTargetPlanet(): Planet
    {
        return $this->targetPlanet;
    }

    #[Pure]
    public function getCurrentPlanet(): ?Planet
    {
        return $this->hyperdriveNavigator->getCurrentPlanet();
    }

    #[Pure]
    public function isPlanetsEqual(): bool
    {
        return $this->getCurrentPlanet() === $this->targetPlanet;
    }

    public function refuelingSpaceship(): void
    {
        $this->spaceship->fullRefueling($this->capital);
    }

    public function jumpToPlanet(Planet $planet): void
    {
        $this->spaceship->fuelConsumption();
        $this->hyperdriveNavigator->jumpTo($planet);
    }

    public function getSpaceshipData(): array
    {
        return $this->spaceship->getSpaceshipData();
    }

    #[ArrayShape([
        "Name" => "string",
        "Capital" => "int",
        "Target Planet" => "string",
        "Current Planet" => "string",
        "Hyperspace Jumps Limit" => "int|null",
    ])]
    public function getPlayerData(): array
    {
        return [
            "Name" => $this->pilot->__toString(),
            "Capital" => $this->capital->getCapital(),
            "Target Planet" => $this->targetPlanet->__toString(),
            "Current Planet" => $this->getCurrentPlanet()->__toString(),
            "Hyperspace Jumps Limit" => $this->hyperdriveNavigator->getHyperspaceJumpsLimit(),
        ];
    }

    public function getMap(): array
    {
        return $this->hyperdriveNavigator->getMap();
    }

    public function hyperspaceJump(): HyperspaceJump
    {
        if ($this->hyperdriveNavigator->getHyperspaceJumpsLimit() <= 0) {
            throw new Exception("Hyperspace jump limit exhausted");
        }
        return new HyperspaceJump($this->hyperdriveNavigator, $this->capital);
    }
}
