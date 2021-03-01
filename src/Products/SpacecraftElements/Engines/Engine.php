<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements\Engines;

use Hyperdrive\Products\SpacecraftElements\SpaceCraftElement;

abstract class Engine extends SpaceCraftElement
{
    protected int $power;
    protected int $fuelUsagePerJump;
    public function __toString(): string
    {
        return $this->name . "\n"
            . "power => " . $this->power . "\n"
            . "weight => " . $this->weight . "\n"
            . "fuel usage per jump => " . $this->fuelUsagePerJump . "\n";
    }

    public function getPower(): int
    {
        return $this->power;
    }

    public function getFuelUsagePerJump(): int
    {
        return $this->fuelUsagePerJump;
    }
}
