<?php

namespace Hyperdrive\Quest;

use Hyperdrive\Geography\Planet;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Pilot\Pilot;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;

class QuestLog
{
    private Collection $quests;
    private Collection $cargo;

    public function __construct()
    {
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

    public function addQuests(HyperdriveNavigator $hyperdrive)
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

    public function showQuests(CLImate $cli) :void
    {
        for ($i = 0; $i < $this->getQuests()->count(); $i++)
        {
            $cli->info("Quest #".$i.":");
            $cli->out("Cargo: ".$this->getQuests()->get($i)->getCargo()->getName());
            $cli->out("Destination: ".$this->getQuests()->get($i)->getDestination());
            $cli->out("Completed: ".$this->getQuests()->get($i)->completionToString());
            $cli->out("Type: ".$this->getQuests()->get($i)->mainToString());
            $cli->out("EXP: ".$this->getQuests()->get($i)->getExp());
            $cli->out("Reward in Credits: ".$this->getQuests()->get($i)->getReward());
            $cli->out("");
        }
    }

    public function checkIfCompleted(Pilot $player,Planet $planet,CLImate $cli) :void
    {
        for ($i = 0; $i < $this->getQuests()->count(); $i++)
        {
            if($this->getQuests()->get($i)->getDestination() === $planet)
            {
                $this->questCompletion($this->getQuests()->get($i),$player,$cli);
            }
        }
    }

    public function questCompletion(Quest $quest,Pilot $player,CLImate $cli): void
    {
        $cli->info("You completed a Quest!");
        $cli->info("You delivered ".$quest->getCargo()->getName()." to ".$quest->getDestination());
        $quest->setCompleted(true);
        $player->earnXP($quest->getExp());
        $player->earnCredits($quest->getReward());
        $player->checkForLevelUp($cli);
    }

    private function finalQuestCompleted(CLImate $cli): void
    {
        $cli->info("You finished your last quest and finished the game!");
        $cli->info("Thank you for playing!");
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