<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Spacecrafts\CombatSpaceCrafts;

use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\SpacecraftElements\Engines\Engine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\FuelTank;
use Hyperdrive\Products\SpacecraftElements\Weapons\Weapon;

class LighterCombatSpaceCraft extends CombatSpaceCraft
{
    public function __construct(Engine $engine, FuelTank $tank, Weapon $weapon)
    {
        parent::__construct($tank, $engine);

        $this->weapon = $weapon;
        $this->curbWeight = 500;
        $this->worth = PriceList::UpgradedCombatSpaceCraftPrice;
        $this->name = "Lighter Combat space Craft";
    }
}
