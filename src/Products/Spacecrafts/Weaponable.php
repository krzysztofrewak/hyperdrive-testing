<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Spacecrafts;

use Hyperdrive\Products\SpacecraftElements\Weapons\Weapon;

trait Weaponable
{
    protected Weapon $weapon;

    public function getWeapon(): Weapon
    {
        return $this->weapon;
    }
}
