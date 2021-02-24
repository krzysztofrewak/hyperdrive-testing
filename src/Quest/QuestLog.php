<?php

namespace Hyperdrive\Quest;

use Hyperdrive\Geography\Planet;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Output\OutputContract;
use Hyperdrive\Pilot\Pilot;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;

class QuestLog
{
    private Collection $quests;
    private Collection $cargo;
    protected OutputContract $output;

    public function __construct(OutputContract $output)
    {
        $this->output = $output;
        $this->quests = collect();
        $this->cargo = collect();
        $this->generateCargo();
    }

    private function generateCargo(): void
    {
        $this->cargo->add(new Cargo(name: "Weapons"));
        $this->cargo->add(new Cargo(name: "Armor"));
        $this->cargo->add(new Cargo(name: "Fuel"));
        $this->cargo->add(new Cargo(name: "Mechanical Parts"));
        $this->cargo->add(new Cargo(name: "Droids"));
        $this->cargo->add(new Cargo(name: "Medicine"));
        $this->cargo->add(new Cargo(name: "Alcohol"));
        $this->cargo->add(new Cargo(name: "Drugs"));
        $this->cargo->shuffle();
    }

    public function addQuest(Quest $quest)
    {
        $this->quests->add($quest);
    }

    public function generateStartingQuests(HyperdriveNavigator $hyperdrive)
    {
        for ($i = 0; $i < 2; $i++)
        {
            $this->addQuest(new Quest(cargo: $this->getRandomCargo(), destination: $hyperdrive->getRandomPlanet(), completed: false, main: false, exp: 2500, reward: $this->generateReward()));
        }
    }

    public function generateReward(): int
    {
        return $reward = rand(100, 500)+1000;
    }

    public function getRandomCargo(): Cargo
    {
        return $this->cargo->random();
    }

    public function showQuests() :void
    {
        for ($i = 0; $i < $this->getQuests()->count(); $i++)
        {
            $this->output->info("Quest #".$i.":");
            $this->output->write("Cargo: ".$this->getQuests()->get($i)->getCargo()->getName());
            $this->output->write("Destination: ".$this->getQuests()->get($i)->getDestination());
            $this->output->write("Completed: ".$this->getQuests()->get($i)->completionToString());
            $this->output->write("Type: ".$this->getQuests()->get($i)->mainToString());
            $this->output->write("EXP: ".$this->getQuests()->get($i)->getExp());
            $this->output->write("Reward in Credits: ".$this->getQuests()->get($i)->getReward());
            $this->output->write("");
        }
    }

    public function checkIfCompleted(Pilot $player,Planet $planet) :void
    {
        for ($i = 0; $i < $this->getQuests()->count(); $i++)
        {
            if($this->getQuests()->get($i)->getDestination() === $planet)
            {
                $this->questCompletion($this->getQuests()->get($i),$player);
            }
        }
    }

    public function questCompletion(Quest $quest,Pilot $player): void
    {
        $this->output->info("You completed a Quest!");
        $this->output->info("You delivered ".$quest->getCargo()->getName()." to ".$quest->getDestination());
        $quest->setCompleted(true);
        $player->earnXP($quest->getExp());
        $player->earnCredits($quest->getReward());
        $player->checkForLevelUp();
    }

    private function finalQuestCompleted(): void
    {
        $this->output->info("You finished your last quest and finished the game!");
        $this->output->info("Thank you for playing!");
        exit(0);
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