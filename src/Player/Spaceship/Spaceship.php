<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Spaceship;

use Hyperdrive\Player\Capital\Capital;
use Hyperdrive\PriceList\PriceList;
use JetBrains\PhpStorm\Pure;

class Spaceship
{
    protected Tank $tank;
    protected string $name;
    protected array $fuelValues;

    public function __construct(array $spaceshipData)
    {
        $this->setSpaceshipData($spaceshipData);
        $this->fuelValues = PriceList::getFuelValues();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    #[Pure]
    public function getFuelConsumed(): int
    {
        return $this->tank->getFuelConsumed();
    }

    public function setFuel(int $fuel): void
    {
        $this->tank->setFuel($fuel);
    }

    public function fuelConsumption(): void
    {
        $this->tank->fuelConsumption();
    }

    public function fullRefueling(Capital $capital): void
    {
        while (!$this->tank->isItFull()) {
            $capital->spendingMoney($this->fuelValues["price"]);
            $this->tank->refueling($this->fuelValues["capacity"]);
        }
    }

    public function getSpaceshipData(): array
    {
        return [
            "name" => $this->name,
        ] + $this->tank->getTankData();
    }

    private function setSpaceshipData(array $spaceshipData): void
    {
        $this->name = $spaceshipData["name"];
        $this->tank = new Tank($spaceshipData["tank"]);
    }
}
