<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements\FuelTanks;

use Decimal\Decimal;
use Hyperdrive\Products\Fuel\Fuel;
use Hyperdrive\Products\PriceList;

class SmallFuelTank extends FuelTank
{
    public function __construct(Fuel $fuel)
    {
        $this->fuel = $fuel;
        $this->capacity = 1100;
        $this->weight = 1000;
        $this->worth = PriceList::SmallFuelTankPrice;
        $this->name = "Small fuel tank";
    }
}
