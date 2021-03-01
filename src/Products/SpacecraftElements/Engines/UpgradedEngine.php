<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements\Engines;

use Hyperdrive\Products\PriceList;

class UpgradedEngine extends Engine
{
    public function __construct()
    {
        $this->power = 90;
        $this->weight = 2000;
        $this->fuelUsagePerJump = 20;
        $this->worth = PriceList::UpgradedEnginePrice;
        $this->name = "Super fuel";
    }
}
