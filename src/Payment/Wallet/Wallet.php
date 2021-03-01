<?php

declare(strict_types=1);

namespace Hyperdrive\Payment\Wallet;

use Hyperdrive\Exceptions\NoCurrencyType;
use Hyperdrive\Payment\Currency\Currency;
use ReflectionClass;

/**
 * Class Wallet
 * @package Hyperdrive\Payment\Wallet
 * @var Currency[] $currencies
 */
class Wallet
{
    private array $currencies = [];

    public function getCurrency(string $currencyType): Currency
    {
        if (!array_key_exists($currencyType, $this->currencies)){
            throw new NoCurrencyType("No currency type");
        }
        return $this->currencies[$currencyType];
    }

    public function addCurrency(Currency $currency): void
    {
        if (array_key_exists($currency::class,$this->currencies)){
            $this->currencies[$currency::class]->addAmount($currency->getAmount());
            unset($currency);
        }
        else {
            $this->currencies[$currency::class] = $currency;
        }
    }
    public function __toString(): string
    {
        $walletString = "";

        foreach ($this->currencies as $currency){
            $reflect = new ReflectionClass($currency);
            $walletString = $walletString . "\n"
                . $reflect->getShortName() . ": " . $currency->getAmount();
            }

        return $walletString;
    }
}
