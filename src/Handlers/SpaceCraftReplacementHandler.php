<?php

namespace Hyperdrive\Handlers;

use Hyperdrive\Exceptions\NoCurrencyType;
use Hyperdrive\Exceptions\NotEnoughMoney;
use Hyperdrive\Exceptions\WrongCurrencyType;
use Hyperdrive\PlanetProperties\Dealers\ProductDealer;
use Hyperdrive\Player\Player;
use Hyperdrive\Products\Spacecrafts\Spacecraft;

class SpaceCraftReplacementHandler
{
    public function handle(Player $player, ProductDealer $dealer): string
    {
        try {
            $currency = $player->getWallet()?->getCurrency($dealer->getCurrencyType());
            /** @var Spacecraft $spaceCraft */
            $newSpaceCraft = $dealer->sell($currency);
        }catch (WrongCurrencyType | NotEnoughMoney | NoCurrencyType $exception){
            return $exception->getMessage();
        }
        $player->setSpaceCraft($newSpaceCraft);

        return "Space craft replacement";
    }
}