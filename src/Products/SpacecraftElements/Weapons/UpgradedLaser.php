<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements\Weapons;

use Hyperdrive\Products\PriceList;

class UpgradedLaser extends Weapon
{
    public function __construct()
    {
        $this->damage = 15;
        $this->weight = 500;
        $this->worth = PriceList::UpgradedLaserPrice;
        $this->name = "Upgraded Laser";
    }
}
