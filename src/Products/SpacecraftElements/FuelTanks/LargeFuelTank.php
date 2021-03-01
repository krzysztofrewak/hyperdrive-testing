<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements\FuelTanks;

use Decimal\Decimal;
use Hyperdrive\Products\Fuel\Fuel;
use Hyperdrive\Products\PriceList;

class LargeFuelTank extends FuelTank
{
    public function __construct(Fuel $fuel)
    {
        $this->fuel = $fuel;
        $this->capacity = 3000;
        $this->weight = 3000;
        $this->worth = PriceList::LargeFuelTankPrice;
        $this->name = "Large fuel tank";
    }
}
