<?php

declare(strict_types=1);

namespace Hyperdrive\PLanetProperties\Cantors;

use Decimal\Decimal;
use Hyperdrive\Payment\Currency\Currency;
use Hyperdrive\Payment\Currency\ImperialCredit;
use Hyperdrive\Payment\Currency\RepublicanCredit;

class ImperialCantor extends Cantor
{
    public function exchangeCurrency(Currency $currency, float $amountToExchange): Currency
    {
        if ($currency instanceof RepublicanCredit) {
            unset($currency);
            return new ImperialCredit(1.0);
        }

        return $currency;
    }

    public function getInfo(): string
    {
        return "cantor info";
    }
}
