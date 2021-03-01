<?php

namespace Hyperdrive\Handlers;

use Hyperdrive\Exceptions\NotEnoughCargoSpace;
use Hyperdrive\PlanetProperties\QuestGivers\QuestGiver;
use Hyperdrive\Player\Player;
use Hyperdrive\Products\Spacecrafts\HybridSpaceCrafts\HybridSpaceCrafts;
use Hyperdrive\Products\Spacecrafts\TrademarkSpaceCrafts\TrademarkSpaceCraft;
use Hyperdrive\Quests\TransportQuest;
use Hyperdrive\Wares\IronOre;

class TransportQuestHandler
{
    public function handle(Player $player, QuestGiver $giver): string
    {
        if ($player->getCurrentQuest() !== null){
            return "You have already active quest";
        }
        if ($player->getSpaceCraft() instanceof TrademarkSpaceCraft || $player->getSpaceCraft() instanceof HybridSpaceCrafts){
            /** @var TransportQuest $quest */
            $quest = $giver->giveQuest();
            try {
                $player->getSpaceCraft()->loadCommodity(new IronOre(quantity: $quest->getCommodityQuantity()));
            }catch (NotEnoughCargoSpace $exception)
            {
                return "Not enough CargoSpace";
            }

            $player->setCurrentQuest($quest);

            return "Quest accepted";
        }
        else {
            return "Your spacecraft can not transport commodity";
        }
    }

}