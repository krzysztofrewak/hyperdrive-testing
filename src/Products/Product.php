<?php

declare(strict_types=1);

namespace Hyperdrive\Products;

use Decimal\Decimal;

abstract class Product
{
    protected float $worth;
    protected string $name;

    public function getWorth(): float
    {
        return $this->worth;
    }
}
