<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements\FuelTanks;

use Hyperdrive\Products\Fuel\Fuel;
use Hyperdrive\Products\SpacecraftElements\SpaceCraftElement;

abstract class FuelTank extends SpaceCraftElement
{
    protected Fuel $fuel;
    protected int $capacity;

    public function __toString(): string
    {
        return $this->name . "\n"
            . "fuel type => " . $this->fuel::class . "\n"
            . "fuel quantity => " . $this->fuel->getQuantityInLiters() . "\n"
            . "tank capacity => " . $this->capacity . "\n";
    }

    public function getFuel(): Fuel
    {
        return $this->fuel;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function refuel(Fuel $fuel): void
    {
        if ($fuel instanceof $this->fuel) {
            $this->fuel->increaseQuantity($fuel->getQuantityInLiters());
        } else {
            $this->fuel = $fuel;
        }
    }
}
