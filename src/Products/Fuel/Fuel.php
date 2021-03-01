<?php

declare(strict_types=1);

namespace Hyperdrive\Products\Fuel;

use Decimal\Decimal;
use Hyperdrive\Products\Product;

abstract class Fuel extends Product
{
    protected int $quantityInLiters;
    protected float $usageFactor;
    protected float $worthPerLiter;

    public function __construct(int $quantityInLiters)
    {
        $this->quantityInLiters = $quantityInLiters;
    }

    public function increaseQuantity(int $quantity): void
    {
        $this->quantityInLiters += $quantity;
    }

    public function decreaseQuantity(int $quantity): void
    {
        if ($quantity > $this->quantityInLiters) {
            throw new \Exception("No such fuel");
        }
        $this->quantityInLiters -= $quantity;
    }

    public function getWorthPerLiter(): float
    {
        return $this->worthPerLiter;
    }

    public function getUsageFactor(): float
    {
        return $this->usageFactor;
    }

    public function getQuantityInLiters(): int
    {
        return $this->quantityInLiters;
    }

    public function getWorth(): float
    {
        return $this->worthPerLiter * $this->quantityInLiters;
    }

    public function getName(): string
    {
        return $this->name;
    }

}
