<?php

namespace Hyperdrive\Handlers;

use Hyperdrive\Exceptions\NoCurrencyType;
use Hyperdrive\Exceptions\NotEnoughMoney;
use Hyperdrive\Exceptions\WrongCurrencyType;
use Hyperdrive\PlanetProperties\Dealers\FuelDealers\FuelDealer;
use Hyperdrive\Player\Player;
use Hyperdrive\Products\Spacecrafts\Spacecraft;

class RefuelHandler
{
    public function handle(Player $player, FuelDealer $dealer, int $fuelQuantity): string
    {
        try {
            $currency = $player->getWallet()?->getCurrency($dealer->getCurrencyType());
            $fuel = $dealer->sell($currency,$fuelQuantity);
        }catch (WrongCurrencyType | NotEnoughMoney | NoCurrencyType $exception){
            return $exception->getMessage();
        }
        $player->getSpaceCraft()?->getFuelTank()?->refuel($fuel);

        return "Space craft replacement";
    }
}