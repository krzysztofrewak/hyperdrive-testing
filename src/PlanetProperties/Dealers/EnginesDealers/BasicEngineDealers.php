<?php

namespace Hyperdrive\PlanetProperties\Dealers\EnginesDealers;

use Hyperdrive\PlanetProperties\Dealers\SpaceCraftElementDealer;
use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\Engines\BasicEngine;

class BasicEngineDealers extends SpaceCraftElementDealer
{
    protected function createProduct(): Product
    {
        return new BasicEngine();
    }

    public function getInfo(): string
    {
        return "Buy basic engine and upgrade your space craft. Price: "
            . round(PriceList::BasicEnginePrice,2);
    }
}