<?php

namespace Hyperdrive\PlanetProperties\Dealers\FuelTankDealers;

use Hyperdrive\PlanetProperties\Dealers\ProductDealer;
use Hyperdrive\PlanetProperties\Dealers\SpaceCraftElementDealer;
use Hyperdrive\Products\Fuel\BasicFuel;
use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\MiddleFuelTank;

class MiddleFuelTankDealer extends SpaceCraftElementDealer
{
    protected function createProduct(): Product
    {
        return new MiddleFuelTank(new BasicFuel(100));
    }

    public function getInfo(): string
    {
        return "Buy middle fuel tank and upgrade your space craft. Price: "
            . round(PriceList::MiddleFuelTankPrice,2);
    }
}