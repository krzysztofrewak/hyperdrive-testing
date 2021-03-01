<?php

namespace Hyperdrive\PlanetProperties\Dealers\EnginesDealers;

use Hyperdrive\PlanetProperties\Dealers\SpaceCraftElementDealer;
use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\Engines\UpgradedEngine;

class UpgradedEngineDealer extends SpaceCraftElementDealer
{
    protected function createProduct(): Product
    {
        return new UpgradedEngine();
    }

    public function getInfo(): string
    {
        return "Buy Upgraded engine and upgrade your space craft. Price: "
            . round(PriceList::UpgradedEnginePrice,2);
    }
}