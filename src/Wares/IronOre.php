<?php

declare(strict_types=1);

namespace Hyperdrive\Wares;

class IronOre extends Commodity
{
    public function __construct(int $quantity)
    {
        parent::__construct($quantity);

        $this->weightPerUnit = 10;
    }
}
