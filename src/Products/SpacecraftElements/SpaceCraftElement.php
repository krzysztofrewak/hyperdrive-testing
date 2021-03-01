<?php

declare(strict_types=1);

namespace Hyperdrive\Products\SpacecraftElements;

use Hyperdrive\Products\Product;

abstract class SpaceCraftElement extends Product
{
    protected int $weight;

    public function getWeight(): int
    {
        return $this->weight;
    }
}
