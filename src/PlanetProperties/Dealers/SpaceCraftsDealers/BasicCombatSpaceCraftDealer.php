<?php

namespace Hyperdrive\PlanetProperties\Dealers\SpaceCraftsDealers;

use Hyperdrive\PlanetProperties\Dealers\SpacecraftDealer;
use Hyperdrive\Products\Fuel\BasicFuel;
use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\Engines\BasicEngine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\SmallFuelTank;
use Hyperdrive\Products\SpacecraftElements\Weapons\BasicLaser;
use Hyperdrive\Products\Spacecrafts\CombatSpaceCrafts\BasicCombatSpaceCraft;

class BasicCombatSpaceCraftDealer extends  SpacecraftDealer
{
    protected function createProduct(): Product
    {
        return new BasicCombatSpaceCraft(
            engine: new BasicEngine(),
            tank: new SmallFuelTank(new BasicFuel(120)),
            weapon:new BasicLaser());
    }

    public function getInfo(): string
    {
        return "Buy Basic Combat space craft, with basic equipment. Price: "
            . round(PriceList::BasicCombatSpaceCraftPrice,2);
    }
}