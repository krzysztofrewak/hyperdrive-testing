<?php

namespace Hyperdrive\Handlers;

use Hyperdrive\Exceptions\NoCurrencyType;
use Hyperdrive\Exceptions\NotEnoughMoney;
use Hyperdrive\Exceptions\WrongCurrencyType;
use Hyperdrive\PlanetProperties\Dealers\ProductDealer;
use Hyperdrive\Player\Player;
use Hyperdrive\Products\SpacecraftElements\SpaceCraftElement;

class SpaceCraftUpgradeHandler
{
    public function handle(Player $player, ProductDealer $dealer): string
    {
        try {
            $currency = $player->getWallet()?->getCurrency($dealer->getCurrencyType());
            /** @var SpaceCraftElement $spaceCraftElement */
            $spaceCraftElement =  $dealer->sell($currency);
        }catch (WrongCurrencyType | NotEnoughMoney | NoCurrencyType $exception){
            return $exception->getMessage();
        }
        $player->getSpaceCraft()?->upgrade($spaceCraftElement);

        return "Element upgraded";
    }
}