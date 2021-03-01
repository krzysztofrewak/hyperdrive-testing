<?php

namespace Hyperdrive\Quests;

use Hyperdrive\Geography\PlanetWithProperties;
use Hyperdrive\Player\Player;

class QuestEnder
{
    public function finishQuest(Player $player): void
    {
        $reward = $player->getCurrentQuest()->getReward();
        $player->deleteCurrentQuest();
        $player->getWallet()->addCurrency($reward);
    }

    public function isFinished(Player $player, PlanetWithProperties $planet): bool
    {
        return $player->getCurrentQuest()?->getDirection() === $planet->getName();
    }
}