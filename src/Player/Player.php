<?php

declare(strict_types=1);

namespace Hyperdrive\Player;

use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Player\Capital\Capital;
use Hyperdrive\Player\FinalScore\FinalScore;
use Hyperdrive\Player\Navigator\HyperdriveNavigator;
use Hyperdrive\Player\Navigator\HyperspaceJump;
use Hyperdrive\Player\Pilot\Pilot;
use Hyperdrive\Player\Spaceship\Spaceship;
use Hyperdrive\PriceList\PriceList;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Config\Definition\Exception\Exception;

class Player
{
    protected Planet $targetPlanet;
    protected int $mapPrice;

    public function __construct(
        protected Capital $capital,
        protected Pilot $pilot,
        protected Spaceship $spaceship,
        protected HyperdriveNavigator $hyperdriveNavigator,
    )
    {
        $this->targetPlanet = $this->hyperdriveNavigator->getRandomPlanet();
        $this->hyperdriveNavigator->getRandomPlanet();
        $this->mapPrice = PriceList::getMapPrice();
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
        "Hyperspace Jumps Limit" => "int",
    ])]
    public function getPlayerData(): array
    {
        return [
            "Name" => $this->pilot->__toString(),
            "Capital" => $this->capital->getCurrentCapital(),
            "Target Planet" => $this->targetPlanet->__toString(),
            "Current Planet" => $this->getCurrentPlanet()->__toString(),
            "Hyperspace Jumps Limit" => $this->hyperdriveNavigator->getRemainingJumpsInHyperspace(),
        ];
    }

    public function buyAccessToTheMap(): void
    {
        $this->capital->spendingMoney($this->mapPrice);
        $this->hyperdriveNavigator->unlockMap();
    }

    public function getMap(): array
    {
        return $this->hyperdriveNavigator->getMap();
    }

    /**
     * @throws Exception
     */
    public function hyperspaceJump(): HyperspaceJump
    {
        if ($this->hyperdriveNavigator->getRemainingJumpsInHyperspace() <= 0) {
            throw new Exception("Hyperspace jump limit exhausted");
        }
        return new HyperspaceJump($this->hyperdriveNavigator, $this->capital);
    }

    #[Pure]
    public function getFinalScore(): FinalScore
    {
        return new FinalScore($this->capital, $this->hyperdriveNavigator, $this->spaceship);
    }
}
