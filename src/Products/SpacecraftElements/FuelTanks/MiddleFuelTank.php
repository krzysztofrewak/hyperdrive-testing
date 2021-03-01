<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements\FuelTanks;

use Decimal\Decimal;
use Hyperdrive\Products\Fuel\Fuel;
use Hyperdrive\Products\PriceList;

class MiddleFuelTank extends FuelTank
{
    public function __construct(Fuel $fuel)
    {
        $this->fuel = $fuel;
        $this->capacity = 2000;
        $this->weight = 2000;
        $this->worth = PriceList::MiddleFuelTankPrice;
        $this->name = "Middle fuel tank";
    }
}
