<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Navigator;

use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Player\Capital\Capital;
use Illuminate\Support\Collection;
use Symfony\Component\Config\Definition\Exception\Exception;

class HyperspaceJump
{
    protected int $price = 200;
    protected int $distance;

    public function __construct(protected HyperdriveNavigator $hyperdriveNavigator, protected Capital $capital)
    {
    }

    public function setDistance(int $distance): void
    {
        $this->capital->isThereEnoughMoney($this->price * $distance);
        $this->distance = $distance;
    }

    public function jumpTo(Planet $planet): void
    {
        $this->capital->spendingMoney($this->price * $this->distance);
        $this->hyperdriveNavigator->hyperspaceJumpTo($planet);
    }

    public function getOptions(): Collection
    {
        $collection = collect();

        $collection->add($this->getDistantPlanet(
            $this->hyperdriveNavigator->getCurrentPlanet()->getId() - $this->distance
        ));
        $collection->add($this->getDistantPlanet(
            $this->hyperdriveNavigator->getCurrentPlanet()->getId() + $this->distance
        ));

        return $collection->filter(function ($value): bool {
            return $value !== null;
        });
    }

    private function getDistantPlanet(int $id): ?Planet
    {
        try {
            return $this->hyperdriveNavigator->getRoute()->getPlanetById($id);
        } catch (Exception) {
            return null;
        }
    }
}
