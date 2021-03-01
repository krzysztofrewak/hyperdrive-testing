<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Spacecrafts\HybridSpaceCrafts;

use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\SpacecraftElements\Engines\Engine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\FuelTank;
use Hyperdrive\Products\SpacecraftElements\Weapons\Weapon;

class UpgradedHybridSpaceCraft extends HybridSpaceCrafts
{
    public function __construct(Engine $engine, FuelTank $tank, Weapon $weapon)
    {
        parent::__construct($tank, $engine);

        $this->weapon = $weapon;
        $this->maxCargoSpaceWeight = 11000;
        $this->curbWeight = 1700;
        $this->worth = PriceList::UpgradedHybridSpaceCraftPrice;
        $this->name = "Upgraded Hybrid space Craft";
    }
}
