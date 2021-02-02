<?php

declare(strict_types=1);

namespace Hyperdrive\Pilot;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Hyperdrive\Pilot\Pilot;
use League\CLImate\CLImate;
use Nette\Utils\ArrayList;


class Party
{

    private Collection $pilots;

    /**
     * Party constructor.
     */
    public function __construct()
    {
        $this->pilots = collect();
        $this->addPilots();
    }

    public function addPilot(Pilot $pilot): void
    {
        $this->pilots->add($pilot);

    }

    public function addPilots(): void
    {
        $this->addPilot(new Pilot("Mark",0,1,3000));
        $this->addPilot(new Pilot("Jack",2,3,2500));
        $this->addPilot(new Pilot("John",4,5,2000));
    }

    public function characterSelection(Pilot $player, CLImate $cli): void
    {
        for ($i = 0; $i < $this->getPilots()->count(); $i++)
        {
            $cli->info("Pilot #".$i.":");
            $cli->out("Name: ".$this->getPilots()->get($i)->getName());
            $cli->out("Reputation: ".$this->getPilots()->get($i)->getReputation()." (More reputation = More difficulties)");
            $cli->out("Skill: ".$this->getPilots()->get($i)->getSkill()." (More skill = Easier Navigation)");
            $cli->out("");
        }

        $options = ["Mark" => "I'm choosing Mark", "Jack" => "I'm choosing Jack", "John" => "I'm choosing John"];
        $result = $cli->radio("Choose your Pilot", $options)->prompt();

        if ($result === "Mark") {
            $player->choosePilot($player,$this->getPilots()->get(0));
        }
        if ($result === "Jack") {
            $player->choosePilot($player,$this->getPilots()->get(1));
        }
        if ($result === "John") {
            $player->choosePilot($player,$this->getPilots()->get(2));
        }

        $cli->info("Your character:");
        $cli->out("Name: ".$player->getName());
        $cli->out("Reputation: ".$player->getReputation());
        $cli->out("Skill: ".$player->getSkill());

    }

    /**
     * @return Collection
     */
    public function getPilots(): Collection
    {
        return $this->pilots;
    }



}
