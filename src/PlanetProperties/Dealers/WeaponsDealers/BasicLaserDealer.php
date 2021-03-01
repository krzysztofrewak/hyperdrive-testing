<?php

namespace Hyperdrive\PlanetProperties\Dealers\WeaponsDealers;

use Hyperdrive\PlanetProperties\Dealers\SpaceCraftElementDealer;
use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\Weapons\BasicLaser;

class BasicLaserDealer extends SpaceCraftElementDealer
{
    protected function createProduct(): Product
    {
        return new BasicLaser();
    }

    public function getInfo(): string
    {
        return "Buy basic laser and upgrade your space craft. Price: "
            . round(PriceList::BasicLaserPrice,2);
    }
}