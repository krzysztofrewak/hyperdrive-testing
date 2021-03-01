<?php

declare(strict_types=1);

namespace Hyperdrive\Payment\Currency;

use Decimal\Decimal;

abstract class Currency
{
    public function __construct(protected float $amount)
    {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function pay(float $amount): void
    {
        $this->amount -= $amount;
    }

    public function addAmount(float $amount): void
    {
        $this->amount += $amount;
    }
}
