<?php

namespace Hyperdrive\Products\Spacecrafts;

use Hyperdrive\Products\Product;
use Hyperdrive\Products\SpacecraftElements\Engines\Engine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\FuelTank;
use Hyperdrive\Products\SpacecraftElements\SpaceCraftElement;

abstract class Spacecraft extends Product
{
    protected int $curbWeight;

    public function __construct(
        protected FuelTank $fuelTank,
         protected Engine $engine
         ){}

    public abstract function getCompleteWeight(): int;

    public abstract function upgrade(SpaceCraftElement $element): void;

    public function fly(): void
    {
        $weightFactor = $this->getCompleteWeight() / 1000;

        $fuelQuantityToUse = $weightFactor * $this->fuelTank->getFuel()?->getUsageFactor()
            * $this->engine?->getFuelUsagePerJump();

        $this->fuelTank->getFuel()->decreaseQuantity($fuelQuantityToUse);
    }

    public function getFuelTank(): FuelTank
    {
        return $this->fuelTank;
    }

    public function getEngine(): Engine
    {
        return $this->engine;
    }

    public function getCurbWeight(): int
    {
        return $this->curbWeight;
    }
}