<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Spacecrafts\CombatSpaceCrafts;

use Hyperdrive\Products\SpacecraftElements\Engines\Engine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\FuelTank;
use Hyperdrive\Products\SpacecraftElements\SpaceCraftElement;
use Hyperdrive\Products\SpacecraftElements\Weapons\Weapon;
use Hyperdrive\Products\Spacecrafts\Spacecraft;
use Hyperdrive\Products\Spacecrafts\Weaponable;

abstract class CombatSpaceCraft extends Spacecraft
{
    use Weaponable;

    public function getCompleteWeight(): int
    {
        return $this->curbWeight + $this->fuelTank->getWeight()
            + $this->engine->getWeight() + $this->weapon->getWeight();
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
            . "weapon => " . $this->weapon . "\n";
    }
}
