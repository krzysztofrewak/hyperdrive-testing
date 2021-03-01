<?php

declare(strict_types=1);

namespace Hyperdrive\PlanetProperties\Dealers\FuelDealers;

use Hyperdrive\Products\Fuel\BasicFuel;
use Hyperdrive\Products\PriceList;

class BasicFuelDealer extends FuelDealer
{
    protected function createFuel(int $fuelQuantity): BasicFuel
    {
        return new BasicFuel($fuelQuantity);
    }

    public function getInfo(): string
    {
        return "Buy basic fuel and upgrade your space craft. Price: "
            . round(PriceList::BasicFuelPrice, 2) . "\l";
    }
}
