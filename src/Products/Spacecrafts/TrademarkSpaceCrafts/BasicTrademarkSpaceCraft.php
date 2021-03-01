<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Spacecrafts\TrademarkSpaceCrafts;

use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\SpacecraftElements\Engines\Engine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\FuelTank;

class BasicTrademarkSpaceCraft extends TrademarkSpaceCraft
{
    public function __construct(Engine $engine, FuelTank $tank)
    {
        parent::__construct($tank, $engine);
        $this->maxCargoSpaceWeight = 12000;
        $this->curbWeight = 1000;
        $this->cargoSpace = null;
        $this->worth = PriceList::BasicTrademarkSpaceCraftPrice;
        $this->name = "Basic Trademark space Craft";
    }
}
