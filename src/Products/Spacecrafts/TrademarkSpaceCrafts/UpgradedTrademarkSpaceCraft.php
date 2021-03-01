<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Spacecrafts\TrademarkSpaceCrafts;

use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\SpacecraftElements\Engines\Engine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\FuelTank;

class UpgradedTrademarkSpaceCraft extends TrademarkSpaceCraft
{
    public function __construct(Engine $engine, FuelTank $tank)
    {
        parent::__construct($tank, $engine);

        $this->maxCargoSpaceWeight = 20000;
        $this->curbWeight = 2000;
        $this->cargoSpace = null;
        $this->worth = PriceList::UpgradedTrademarkSpaceCraftPrice;
        $this->name = "Upgraded Trademark space Craft";
    }
}
