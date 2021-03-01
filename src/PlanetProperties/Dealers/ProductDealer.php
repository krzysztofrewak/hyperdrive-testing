<?php

namespace Hyperdrive\PlanetProperties\Dealers;

use Hyperdrive\Exceptions\NotEnoughMoney;
use Hyperdrive\Exceptions\WrongCurrencyType;
use Hyperdrive\PlanetProperties\Property;
use Hyperdrive\Payment\Currency\Currency;
use Hyperdrive\Products\Product;

abstract class ProductDealer implements Property
{
    public function __construct(
        protected string $currencyType,
    ){}

    public function sell(Currency $currency): Product
    {
        if ($currency::class !== $this->currencyType){
            throw new WrongCurrencyType("Wrong currency type");
        }

        $product = $this->createProduct();

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

    protected abstract function createProduct(): Product;

}