<?php

namespace Hyperdrive\PlanetProperties\Dealers\SpaceCraftsDealers;

use Hyperdrive\PlanetProperties\Dealers\SpacecraftDealer;
use Hyperdrive\Products\Fuel\BasicFuel;
use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\Engines\BasicEngine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\SmallFuelTank;
use Hyperdrive\Products\Spacecrafts\TrademarkSpaceCrafts\BasicTrademarkSpaceCraft;

class BasicTrademarkSpaceCraftDealer extends SpacecraftDealer
{
    protected function createProduct(): Product
    {
        return new BasicTrademarkSpaceCraft(
            engine: new BasicEngine(),
            tank: new SmallFuelTank(new BasicFuel(120))
        );
    }

    public function getInfo(): string
    {
        return "Buy Basic trademark space craft, with basic equipment. Price: "
            . round(PriceList::BasicTrademarkSpaceCraftPrice,2);
    }
}