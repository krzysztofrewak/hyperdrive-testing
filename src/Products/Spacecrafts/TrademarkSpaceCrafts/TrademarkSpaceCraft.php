<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Spacecrafts\TrademarkSpaceCrafts;

use Hyperdrive\Products\SpacecraftElements\Engines\Engine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\FuelTank;
use Hyperdrive\Products\SpacecraftElements\SpaceCraftElement;
use Hyperdrive\Products\Spacecrafts\Cargoable;
use Hyperdrive\Products\Spacecrafts\Spacecraft;

abstract class TrademarkSpaceCraft extends Spacecraft
{
    use Cargoable;

    public function getCompleteWeight(): int
    {
        return $this->curbWeight + $this->fuelTank->getWeight()
            + $this->engine->getWeight() + $this->cargoSpace?->getCompleteWeight();
    }

    public function upgrade(SpaceCraftElement $element): void
    {
        if ($element instanceof FuelTank) {
            $this->fuelTank = $element;
        } elseif ($element instanceof Engine) {
            $this->engine = $element;
        }
    }

    public function __toString(): string
    {
        return $this->name . " => \n"
            . "engine => " . $this->engine . "\n"
            . "fuel tank => " . $this->fuelTank . "\n"
            . "max cargo space weight => " . $this->maxCargoSpaceWeight . "\n";
    }
}
