<?php

declare(strict_types=1);

namespace Hyperdrive\PlanetProperties\Dealers\FuelDealers;

use Hyperdrive\Products\Fuel\SuperFuel;
use Hyperdrive\Products\PriceList;

class SuperFuelDealer extends FuelDealer
{
    protected function createFuel(int $fuelQuantity): SuperFuel
    {
        return new SuperFuel($fuelQuantity);
    }

    public function getInfo(): string
    {
        return "Buy super fuel and upgrade your space craft. Price: "
            . round(PriceList::SuperFuelPrice,2) . "\l";
    }
}
