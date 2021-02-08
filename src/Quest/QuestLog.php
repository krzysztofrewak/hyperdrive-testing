<?php

namespace Hyperdrive\Quest;

use Hyperdrive\Geography\Planet;
use Hyperdrive\HyperdriveNavigator;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;

class QuestLog
{
    private Collection $quests;
    private Collection $cargo;

    public function __construct()
    {
        $this->quests = collect();

    }

    public function generateCargo(): void
    {
        $this->cargo->add(new Cargo("Weapons"));
        $this->cargo->add(new Cargo("Armor"));
        $this->cargo->add(new Cargo("Fuel"));
        $this->cargo->add(new Cargo("Mechanical Parts"));
        $this->cargo->add(new Cargo("Droids"));
        $this->cargo->add(new Cargo("Medicine"));
        $this->cargo->add(new Cargo("Alcohol"));
        $this->cargo->add(new Cargo("Drugs"));
        $this->cargo->shuffle();
    }

    public function addQuest(Quest $quest)
    {
        $this->quests->add($quest);
    }

    public function addQuests(HyperdriveNavigator $hyperdrive)
    {
        $this->addQuest(new Quest(new Cargo("Weapons"),$hyperdrive->getRandomPlanet(),false));
        $this->addQuest(new Quest(new Cargo("Fuel"),$hyperdrive->getRandomPlanet(),false));
        $this->addQuest(new Quest(new Cargo("Mechanical Parts"),$hyperdrive->getRandomPlanet(),false));
    }


    public function showQuests(CLImate $cli) :void
    {
        for ($i = 0; $i < $this->getQuests()->count(); $i++)
        {
            $cli->info("Quest #".$i.":");
            //$cli->out("Cargo: ".$this->getQuests()->get($i)->getCargo()->getName());
            $cli->out("Destination: ".$this->getQuests()->get($i)->getDestination());
            $cli->out("Completed: ".$this->getQuests()->get($i)->completionToString());
            $cli->out("");
        }
    }

    public function checkIfCompleted(Planet $planet) :void
    {
        for ($i = 0; $i < $this->getQuests()->count(); $i++)
        {
            if($this->getQuests()->get($i)->getDestination() === $planet)
            {
                $this->getQuests()->get($i)->setCompleted(true);
            }
        }
    }

    public function AreAllQuestsCompleted() :bool
    {
        $complete = 0;

        for ($i = 0; $i < $this->getQuests()->count(); $i++)
        {
            if($this->getQuests()->get($i)->isCompleted())
            {
                $complete++;
            }
        }

        if ($complete == $this->getQuests()->count())
        {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @return Collection
     */
    public function getQuests(): Collection
    {
        return $this->quests;
    }

    /**
     * @param Collection $quests
     */
    public function setQuests(Collection $quests): void
    {
        $this->quests = $quests;
    }



}