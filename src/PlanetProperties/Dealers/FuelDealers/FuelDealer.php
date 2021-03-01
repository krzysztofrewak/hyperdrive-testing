<?php

namespace Hyperdrive\PlanetProperties\Dealers\FuelDealers;

use Hyperdrive\Exceptions\NotEnoughMoney;
use Hyperdrive\Exceptions\WrongCurrencyType;
use Hyperdrive\PlanetProperties\Property;
use Hyperdrive\Payment\Currency\Currency;
use Hyperdrive\Products\Fuel\Fuel;

abstract class FuelDealer implements Property
{
    public function __construct(
        protected string $currencyType)
    {}

    public function sell(Currency $currency, int $fuelQuantity)
    {
        if ($currency::class !== $this->currencyType){
            throw new WrongCurrencyType("Wrong currency type");
        }

        $product = $this->createFuel($fuelQuantity);

        if ($product->getWorth() > $currency->getAmount()){
            throw new NotEnoughMoney("No enough money");
        }

        $currency->pay($product->getWorth());

        return $product;
    }

    public function getCurrencyType(): string
    {
        return $this->currencyType;
    }

    protected abstract function createFuel(int $fuelQuantity): Fuel;
}