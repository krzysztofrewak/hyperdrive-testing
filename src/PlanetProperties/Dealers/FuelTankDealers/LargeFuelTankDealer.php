<?php

namespace Hyperdrive\PlanetProperties\Dealers\FuelTankDealers;

use Hyperdrive\PlanetProperties\Dealers\SpaceCraftElementDealer;
use Hyperdrive\Products\Fuel\BasicFuel;
use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\LargeFuelTank;

class LargeFuelTankDealer extends SpaceCraftElementDealer
{

    protected function createProduct(): Product
    {
        return new LargeFuelTank(new BasicFuel(100));
    }

    public function getInfo(): string
    {
        return "Buy large fuel tank and upgrade your space craft. Price: "
            . round(PriceList::LargeFuelTankPrice,2);
    }
}