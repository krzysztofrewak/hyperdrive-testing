<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Fuel;

use Decimal\Decimal;
use Hyperdrive\Products\PriceList;

class SuperFuel extends Fuel
{
    public function __construct(int $quantityInLiters)
    {
        parent::__construct($quantityInLiters);

        $this->usageFactor = 0.8;
        $this->worthPerLiter = PriceList::SuperFuelPrice;
        $this->name = "Super fuel";

    }
}
