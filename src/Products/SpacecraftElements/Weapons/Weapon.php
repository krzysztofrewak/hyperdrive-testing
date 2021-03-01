<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements\Weapons;

use Hyperdrive\Products\SpacecraftElements\SpaceCraftElement;

abstract class Weapon extends SpaceCraftElement
{
    protected int $damage;

    public function __toString(): string
    {
        return $this->name . "\n"
            . "damage => " . $this->damage . "\n"
            . "weight => " . $this->weight . "\n";
    }

    public function getDamage(): int
    {
        return $this->damage;
    }
}
