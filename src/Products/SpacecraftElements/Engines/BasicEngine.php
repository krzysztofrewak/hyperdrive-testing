<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements\Engines;

use Hyperdrive\Products\PriceList;

class BasicEngine extends Engine
{
    public function __construct()
    {
        $this->power = 70;
        $this->weight = 2000;
        $this->fuelUsagePerJump = 20;
        $this->worth = PriceList::BasicEnginePrice;
        $this->name = "Basic Engine";
    }
}
