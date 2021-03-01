<?php

namespace Hyperdrive\Factories;

use Hyperdrive\Payment\Currency\ImperialCredit;
use Hyperdrive\Payment\Currency\RepublicanCredit;
use Hyperdrive\Payment\Wallet\Wallet;
use Hyperdrive\Player\Player;
use Hyperdrive\Products\Fuel\BasicFuel;
use Hyperdrive\Products\SpacecraftElements\Engines\BasicEngine;
use Hyperdrive\Products\SpacecraftElements\FuelTanks\SmallFuelTank;
use Hyperdrive\Products\Spacecrafts\Spacecraft;
use Hyperdrive\Products\Spacecrafts\TrademarkSpaceCrafts\BasicTrademarkSpaceCraft;

class PLayerFactory
{
    public function createPlayer(): Player
    {
        $wallet = new Wallet();
        $wallet->addCurrency(new ImperialCredit(2000));
        $wallet->addCurrency(new RepublicanCredit(2000));
        $spacecraft = new BasicTrademarkSpaceCraft(engine:new BasicEngine(),
            tank: new SmallFuelTank(new BasicFuel(1000)));

        return new Player(wallet: $wallet, spaceCraft: $spacecraft);
    }
}