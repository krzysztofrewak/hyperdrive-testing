<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Navigator;

use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Player\Capital\Capital;
use Illuminate\Support\Collection;
use Symfony\Component\Config\Definition\Exception\Exception;

class HyperspaceJump
{
    protected Collection $matchingPlanets;
    protected HyperspaceJumpOption $jumpOption;

    public function __construct(protected HyperdriveNavigator $hyperdriveNavigator, protected Capital $capital)
    {
        $this->matchingPlanets = collect();
    }

    public function setJumpOption(HyperspaceJumpOption $hyperspaceJumpOption): void
    {
        $this->jumpOption = $hyperspaceJumpOption;
        $this->capital->isThereEnoughMoney($this->jumpOption->getPrice());
    }

    public function jumpTo(Planet $planet): void
    {
        $this->capital->spendingMoney($this->jumpOption->getPrice());
        $this->hyperdriveNavigator->hyperspaceJumpTo($planet);
    }

    public function getMatchingPlanets(): Collection
    {
        $this->getDistantPlanet(
            $this->hyperdriveNavigator->getCurrentPlanet()->getId() - $this->jumpOption->getDistance()
        );
        $this->getDistantPlanet(
            $this->hyperdriveNavigator->getCurrentPlanet()->getId() + $this->jumpOption->getDistance()
        );
        return $this->matchingPlanets;
    }

    private function getDistantPlanet(int $id): void
    {
        try {
            $this->matchingPlanets->add($this->hyperdriveNavigator->getRoute()->getPlanetById($id));
        } catch (Exception) {
        }
    }
}
