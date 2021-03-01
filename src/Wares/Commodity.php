<?php

declare(strict_types=1);

namespace Hyperdrive\Wares;

abstract class Commodity
{
    protected int $quantity;
    protected int $weightPerUnit;

    public function __construct(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getWeightPerUnit(): int
    {
        return $this->weightPerUnit;
    }

    public function getCompleteWeight(): int
    {
        return $this->weightPerUnit * $this->quantity;
    }
}
