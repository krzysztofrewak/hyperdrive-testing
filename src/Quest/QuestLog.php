<?php

namespace Hyperdrive\Quest;

use Hyperdrive\Geography\Planet;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Output\OutputContract;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Story\Story;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

class QuestLog
{
    private Collection $quests;
    private Collection $cargo;
    protected OutputContract $output;
    private Story $story;
    private int $mainQuestsCompleted;


    public function __construct(OutputContract $output, Story $story)
    {
        $this->output = $output;
        $this->quests = collect();
        $this->cargo = collect();
        $this->generateCargo();
        $this->mainQuestsCompleted = 0;
        $this->story = $story;
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
        $this->output->info("NEW QUEST ADDED - Deliver " . $quest->getCargo()->getName() . " to " . $quest->getDestination());
    }

    public function generateStartingQuests(HyperdriveNavigator $hyperdrive)
    {
        $this->addQuest(new Quest(cargo: new Cargo(name: "Mysterious Box"), destination: $hyperdrive->getRandomPlanet(), completed: false, main: true, exp: 5000, reward: 10000));

        for ($i = 0; $i < 2; $i++) {
            $this->addQuest(new Quest(cargo: $this->getRandomCargo(), destination: $hyperdrive->getRandomPlanet(), completed: false, main: false, exp: 2500, reward: $this->generateReward()));
        }
    }

    #[Pure] public function generateReward(): int
    {
        return rand(100, 500) + 1000;
    }

    public function showQuests(): void
    {
        for ($i = 0; $i < $this->getQuests()->count(); $i++) {
            if(!$this->getQuests()->get($i)->isCompleted()){
                $this->output->write("");
                $this->output->info("Quest #" . $i+1 . ":");
                $this->output->write("Cargo: " . $this->getQuests()->get($i)->getCargo()->getName());
                $this->output->write("Destination: " . $this->getQuests()->get($i)->getDestination());
                $this->output->write("Type: " . $this->getQuests()->get($i)->mainToString());
                $this->output->write("EXP: " . $this->getQuests()->get($i)->getExp());
                $this->output->write("Reward in Credits: " . $this->getQuests()->get($i)->getReward());
                $this->output->write("");
            }
        }
    }

    public function checkIfCompleted(Pilot $player, Planet $planet,HyperdriveNavigator $hyperdrive): void
    {
        for ($i = 0; $i < $this->getQuests()->count(); $i++) {
            if ($this->getQuests()->get($i)->getDestination() === $planet && !$this->getQuests()->get($i)->isCompleted()) {
                $this->questCompletion($this->getQuests()->get($i), $player,$hyperdrive);
            }
        }
    }

    private function questCompletion(Quest $quest, Pilot $player,HyperdriveNavigator $hyperdrive): void
    {
        $this->output->write("");
        $this->output->info("You completed a Quest!");
        $this->output->info("You delivered " . $quest->getCargo()->getName() . " to " . $quest->getDestination());
        $quest->setCompleted(true);
        $player->earnXP($quest->getExp());
        $player->earnCredits($quest->getReward());
        $player->checkForLevelUp();
        if ($quest->isMain()) {
            $this->mainQuestsCompleted++;
            $this->story->mainQuests($this->mainQuestsCompleted);
            $this->addQuest(new Quest(cargo: new Cargo(name: "Corran Horn"), destination: $hyperdrive->getRandomPlanet(), completed: false, main: true, exp: 5000, reward: 20000));
        }
    }

    public function getQuests(): Collection
    {
        return $this->quests;
    }

    public function getRandomCargo(): Cargo
    {
        return $this->cargo->random();
    }


}