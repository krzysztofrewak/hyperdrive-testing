<?php

namespace Hyperdrive\PLanetProperties\Cantors;

use Decimal\Decimal;
use Hyperdrive\Payment\Currency\Currency;
use Hyperdrive\PlanetProperties\Property;

abstract class Cantor implements Property
{
    public function __construct(protected float $exchangeRate)
    {
    }

    public abstract function exchangeCurrency(Currency $currency, float $amountToExchange): Currency;

    public function getExchangeRate(): float
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(float $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
    }
}