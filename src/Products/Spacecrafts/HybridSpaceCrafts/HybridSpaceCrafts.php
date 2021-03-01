<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Spacecrafts\HybridSpaceCrafts;

use Hyperdrive\Products\SpacecraftElements\Engines\Engine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\FuelTank;
use Hyperdrive\Products\SpacecraftElements\SpaceCraftElement;
use Hyperdrive\Products\SpacecraftElements\Weapons\Weapon;
use Hyperdrive\Products\Spacecrafts\Cargoable;
use Hyperdrive\Products\Spacecrafts\Spacecraft;
use Hyperdrive\Products\Spacecrafts\Weaponable;

abstract class HybridSpaceCrafts extends Spacecraft
{
    use Cargoable;
    use Weaponable;

    public function getCompleteWeight(): int
    {
        return $this->curbWeight + $this->fuelTank->getWeight()
            + $this->engine->getWeight() + $this->weapon->getWeight()
            + $this->cargoSpace->getCompleteWeight();
    }

    public function upgrade(SpaceCraftElement $element): void
    {
        if ($element instanceof Weapon) {
            $this->weapon = $element;
        } elseif ($element instanceof FuelTank) {
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
