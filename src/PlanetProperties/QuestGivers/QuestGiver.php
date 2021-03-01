<?php

namespace Hyperdrive\PlanetProperties\QuestGivers;

use Hyperdrive\PlanetProperties\Property;
use Hyperdrive\Quests\Quest;

abstract class QuestGiver implements Property
{
    public abstract function giveQuest(): Quest;
}