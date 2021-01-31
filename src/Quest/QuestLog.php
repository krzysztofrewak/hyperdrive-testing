<?php


namespace Hyperdrive\Quest;


use Hyperdrive\HyperdriveNavigator;
use Illuminate\Support\Collection;

class QuestLog
{
    protected Collection $quests;


    public function __construct()
    {
        $this->quests = collect();
        $this->addQuests();
    }

    private function addQuests(HyperdriveNavigator $hyperdrive)
    {
        $this->quests->add(new Quest(new Cargo("Weapons"),$hyperdrive->getRandomPlanet(),false));
        $this->quests->add(new Quest(new Cargo("Mechanical Parts"),$hyperdrive->getRandomPlanet(),false));
        $this->quests->add(new Quest(new Cargo("Fuel"),$hyperdrive->getRandomPlanet(),false));
    }

    private function completeQuest()
    {
        //if completed then delete from collection
    }


}