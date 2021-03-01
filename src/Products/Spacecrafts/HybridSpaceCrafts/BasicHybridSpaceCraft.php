<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Spacecrafts\HybridSpaceCrafts;

use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\SpacecraftElements\Engines\Engine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\FuelTank;
use Hyperdrive\Products\SpacecraftElements\Weapons\Weapon;

class BasicHybridSpaceCraft extends HybridSpaceCrafts
{
    public function __construct(Engine $engine, FuelTank $tank, Weapon $weapon)
    {
        parent::__construct($tank, $engine);

        $this->weapon = $weapon;
        $this->maxCargoSpaceWeight = 9000;
        $this->curbWeight = 1500;
        $this->worth = PriceList::BasicHybridSpaceCraftPrice;
        $this->name = "Basic Hybrid space Craft";
    }
}
