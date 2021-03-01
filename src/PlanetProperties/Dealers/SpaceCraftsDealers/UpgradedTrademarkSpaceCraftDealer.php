<?php

namespace Hyperdrive\PlanetProperties\Dealers\SpaceCraftsDealers;

use Hyperdrive\PlanetProperties\Dealers\ProductDealer;
use Hyperdrive\PlanetProperties\Dealers\SpacecraftDealer;
use Hyperdrive\Products\Fuel\BasicFuel;
use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\Engines\BasicEngine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\SmallFuelTank;
use Hyperdrive\Products\SpacecraftElements\Weapons\BasicLaser;
use Hyperdrive\Products\Spacecrafts\HybridSpaceCrafts\UpgradedHybridSpaceCraft;

class UpgradedTrademarkSpaceCraftDealer extends SpacecraftDealer
{
    protected function createProduct(): Product
    {
        return new UpgradedHybridSpaceCraft(
            engine: new BasicEngine(),
            tank: new SmallFuelTank(new BasicFuel(120)),
            weapon:new BasicLaser());
    }

    public function getInfo(): string
    {
        return "Buy upgraded trademark space craft, with basic equipment. Price: "
            . round(PriceList::UpgradedTrademarkSpaceCraftPrice,2);
    }
}