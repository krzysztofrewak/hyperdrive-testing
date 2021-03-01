<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements\Weapons;

use Hyperdrive\Products\PriceList;

class BasicLaser extends Weapon
{
    public function __construct()
    {
        $this->damage = 10;
        $this->weight = 400;
        $this->worth = PriceList::BasicLaserPrice;
        $this->name = "Basic Laser";
    }
}
