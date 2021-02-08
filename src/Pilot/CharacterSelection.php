<?php

declare(strict_types=1);

namespace Hyperdrive\Pilot;

use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Ship\Ship;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;


class CharacterSelection
{

    private Collection $pilots;
    private Collection $ships;

    /**
     * CharacterSelection constructor.
     */
    public function __construct()
    {
        $this->pilots = collect();
        $this->ships = collect();
        $this->addPilots();
        $this->addShips();
    }

    public function addPilot(Pilot $pilot): void
    {
        $this->pilots->add($pilot);

    }

    public function addPilots(): void
    {
        $this->addPilot(new Pilot("Atton Rand",5,5,3000,0));
        $this->addPilot(new Pilot("Jarrnes Corring",3,3,2500,0));
        $this->addPilot(new Pilot("Garfinn Newdor",0,2,2000,0));
    }

    public function characterSelection(Pilot $player,Ship $playerShip, CLImate $cli): void
    {
        for ($i = 0; $i < $this->getPilots()->count(); $i++)
        {
            $cli->info("Pilot #".$i.":");
            $cli->out("Name: ".$this->getPilots()->get($i)->getName());
            $cli->out("Reputation: ".$this->getPilots()->get($i)->getReputation()." (More reputation = More difficulties)");
            $cli->out("Skill: ".$this->getPilots()->get($i)->getSkill()." (More skill = Easier Navigation)");
            $cli->out("");
        }

        $options = ["Atton" => "I'm choosing Atton", "Jarrnes" => "I'm choosing Jarrnes", "Garfinn" => "I'm choosing Garfinn"];
        $result = $cli->radio("Choose your Pilot", $options)->prompt();

        if ($result === "Atton") {
            $player->choosePilot($player,$this->getPilots()->get(0));
        }
        if ($result === "Jarrnes") {
            $player->choosePilot($player,$this->getPilots()->get(1));
        }
        if ($result === "Garfinn") {
            $player->choosePilot($player,$this->getPilots()->get(2));
        }

        for ($i = 0; $i < $this->getShips()->count(); $i++)
        {
            $cli->info("Ship #".$i.":");
            $cli->out("Name: ".$this->getShips()->get($i)->getName());
            $cli->out("Max Fuel: ".$this->getShips()->get($i)->getMaxFuel());
            $cli->out("Max Shields ".$this->getShips()->get($i)->getMaxShields());
            $cli->out("Max Hull Integrity ".$this->getShips()->get($i)->getMaxHullIntegrity());
            $cli->out("Missile Damage: ".$this->getShips()->get($i)->getMissileDamage());
            $cli->out("Laser Damage ".$this->getShips()->get($i)->getLaserDamage());
        }

        $options = ["EbonHawk" => "I'm choosing Ebon Hawk", "Typhoon" => "I'm choosing Typhoon", "Cyclone" => "I'm choosing Cyclone"];
        $result = $cli->radio("Choose your Ship", $options)->prompt();

        if ($result === "EbonHawk") {
            $playerShip->chooseShip($playerShip,$this->getShips()->get(0));
        }
        if ($result === "Typhoon") {
            $playerShip->chooseShip($playerShip,$this->getShips()->get(1));
        }
        if ($result === "Cyclone") {
            $playerShip->chooseShip($playerShip,$this->getShips()->get(2));
        }

        $cli->info("Your character:");
        $cli->out("Name: ".$player->getName());
        $cli->out("Reputation: ".$player->getReputation());
        $cli->out("Skill: ".$player->getSkill());

        $cli->info("Your ship:");
        $cli->out("Name: ".$playerShip->getName());
        $cli->out("Max Fuel: ".$playerShip->getMaxFuel());
        $cli->out("Max Shields ".$playerShip->getMaxShields());
        $cli->out("Max Hull Integrity ".$playerShip->getMaxHullIntegrity());
        $cli->out("Missile Damage: ".$playerShip->getMissileDamage());
        $cli->out("Laser Damage ".$playerShip->getLaserDamage());
    }

    /**
     * @return Collection
     */
    public function getPilots(): Collection
    {
        return $this->pilots;
    }

    /**
     * @return Collection
     */
    public function getShips(): Collection
    {
        return $this->ships;
    }



    private function addShips()
    {
        $this->addShip(new Ship("Ebon Hawk",100,100,150,150,150,150,80,60));
        $this->addShip(new Ship("Typhoon",120,120,200,200,100,100,100,60));
        $this->addShip(new Ship("Cyclone",80,80,100,100,200,200,70,60));
    }

    private function addShip(Ship $ship)
    {
        $this->ships->add($ship);
    }


}
