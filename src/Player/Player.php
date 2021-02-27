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

    public function getMap(): array
    {
        return $this->hyperdriveNavigator->getMap();
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
    public function getPilot(): Pilot
    {
        return $this->pilot;
    }

    public function getSpaceship(): Spaceship
    {
        return $this->spaceship;
    }

    #[Pure]
    public function getCurrentCapital(): int
    {
        return $this->capital->getCurrentCapital();
    }

    #[Pure]
    public function getRemainingJumpsInHyperspace(): int
    {
        return $this->hyperdriveNavigator->getRemainingJumpsInHyperspace();
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

    public function buyAccessToTheMap(): void
    {
        $this->capital->spendingMoney($this->mapPrice);
        $this->hyperdriveNavigator->unlockMap();
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
    public function generateFinalScore(): FinalScore
    {
        return new FinalScore($this->capital, $this->hyperdriveNavigator, $this->spaceship);
    }
}
