<?php

namespace Hyperdrive\PlanetProperties\Dealers\WeaponsDealers;

use Hyperdrive\PlanetProperties\Dealers\SpaceCraftElementDealer;
use Hyperdrive\Products\PriceList;
use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\Weapons\UpgradedLaser;

class UpgradedLaserDealer extends SpaceCraftElementDealer
{
    protected function createProduct(): Product
    {
        return new UpgradedLaser();
    }

    public function getInfo(): string
    {
        return "Buy upgraded laser and upgrade your space craft. Price: "
            . round(PriceList::UpgradedLaserPrice,2);
    }
}