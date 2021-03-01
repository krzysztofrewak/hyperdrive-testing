<?php

declare(strict_types=1);

namespace Hyperdrive\PLanetProperties\Cantors;

use Decimal\Decimal;
use Hyperdrive\Payment\Currency\Currency;
use Hyperdrive\Payment\Currency\ImperialCredit;
use Hyperdrive\Payment\Currency\RepublicanCredit;

class RepublicanCantor extends Cantor
{
    public function exchangeCurrency(Currency $currency, float $amountToExchange): Currency
    {
        if ($currency instanceof ImperialCredit) {
            unset($currency);
            return new RepublicanCredit(1);
        }

        return $currency;
    }

    public function getInfo(): string
    {
        return "cantor info";
    }
}
