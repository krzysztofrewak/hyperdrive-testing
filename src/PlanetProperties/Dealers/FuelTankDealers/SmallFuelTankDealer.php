<?php

namespace Hyperdrive\PlanetProperties\Dealers\FuelTankDealers;

use Hyperdrive\PlanetProperties\Dealers\SpaceCraftElementDealer;
use Hyperdrive\Products\Fuel\BasicFuel;
use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\SmallFuelTank;

class SmallFuelTankDealer extends SpaceCraftElementDealer
{
    protected function createProduct(): Product
    {
        return new SmallFuelTank(new BasicFuel(100));
    }

    public function getInfo(): string
    {
        return "Buy small fuel tank and upgrade your space craft. Price: "
            . round(PriceList::SmallFuelTankPrice,2);
    }
}