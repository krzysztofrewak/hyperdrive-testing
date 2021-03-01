<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Fuel;

use Decimal\Decimal;
use Hyperdrive\Products\PriceList;

class BasicFuel extends Fuel
{
    public function __construct(int $quantityInLiters)
    {
        parent::__construct($quantityInLiters);

        $this->usageFactor = 1.0;
        $this->worthPerLiter = PriceList::BasicFuelPrice;
        $this->name = "Basic fuel";
    }
}
