<?php

namespace Hyperdrive\PlanetProperties\QuestGivers;

use Hyperdrive\Payment\Currency\ImperialCredit;
use Hyperdrive\Quests\TransportQuest;
use Hyperdrive\Wares\IronOre;

class IronOreTransportQuestGiver extends QuestGiver
{
    public function giveQuest(): TransportQuest
    {
        return new TransportQuest(
            direction: "Draria",
            commodityType: IronOre::class,
            commodityQuantity: 500,
            reward: new ImperialCredit(1000)
        );
    }

    public function getInfo(): string
    {
        return "Transport quest: "
            . "commodity type: iron ore "
            . "quantity: " . 500
            . " direction: " . "Draria";
    }
}