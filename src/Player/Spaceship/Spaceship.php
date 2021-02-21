<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Spaceship;

use Hyperdrive\Player\Capital\Capital;

class Spaceship
{
    protected Tank $tank;
    protected string $name;
    protected int $fuelPrice = 50;

    public function __construct(array $spaceshipData)
    {
        $this->setSpaceshipData($spaceshipData);
    }

    public function __toString(): string
    {
        return $this->name;
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
            $capital->spendingMoney($this->fuelPrice);
            $this->tank->refueling();
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
