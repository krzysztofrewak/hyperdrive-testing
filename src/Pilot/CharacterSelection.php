<?php

declare(strict_types=1);

namespace Hyperdrive\Pilot;

use Hyperdrive\Output\OutputContract;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Ship\Ship;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;


class CharacterSelection implements OutputContract
{

    private Collection $pilots;
    private Collection $ships;
    private CLImate $cli;

    /**
     * CharacterSelection constructor.
     * @param CLImate $cli
     */

    public function __construct(CLImate $cli)
    {
        $this->pilots = collect();
        $this->ships = collect();
        $this->addPilots();
        $this->addShips();
        $this->cli = $cli;
    }


    public function addPilot(Pilot $pilot): void
    {
        $this->pilots->add($pilot);

    }

    public function addPilots(): void
    {
        $this->addPilot(new Pilot(name: "Atton Rand", reputation: 5, skill: 5, credits: 3000, exp: 0));
        $this->addPilot(new Pilot(name: "Jarrnes Corring", reputation: 3, skill: 3, credits: 2500, exp: 0));
        $this->addPilot(new Pilot(name: "Garfinn Newdor", reputation: 0, skill: 2, credits: 2000, exp: 0));
    }

    public function characterSelection(Pilot $player,Ship $playerShip): void
    {
        for ($i = 0; $i < $this->getPilots()->count(); $i++)
        {
            $this->info("Pilot #".$i.":");
            $this->write("Name: ".$this->getPilots()->get($i)->getName());
            $this->write("Reputation: ".$this->getPilots()->get($i)->getReputation()." (More reputation = More difficulties)");
            $this->write("Skill: ".$this->getPilots()->get($i)->getSkill()." (More skill = Easier Navigation)");
            $this->write("Credits: ".$this->getPilots()->get($i)->getCredits());
            $this->write("");
        }

        $options = ["Atton" => "I'm choosing Atton", "Jarrnes" => "I'm choosing Jarrnes", "Garfinn" => "I'm choosing Garfinn"];
        $result = $this->cli->radio("Choose your Pilot", $options)->prompt();

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
            $this->info("Ship #".$i.":");
            $this->write("Name: ".$this->getShips()->get($i)->getName());
            $this->write("Max Fuel: ".$this->getShips()->get($i)->getMaxFuel());
            $this->write("Max Shields ".$this->getShips()->get($i)->getMaxShields());
            $this->write("Max Hull Integrity ".$this->getShips()->get($i)->getMaxHullIntegrity());
            $this->write("Missile Damage: ".$this->getShips()->get($i)->getMissileDamage());
            $this->write("Laser Damage ".$this->getShips()->get($i)->getLaserDamage());
        }

        $options = ["EbonHawk" => "I'm choosing Ebon Hawk", "Typhoon" => "I'm choosing Typhoon", "Cyclone" => "I'm choosing Cyclone"];
        $result = $this->cli->radio("Choose your Ship", $options)->prompt();

        if ($result === "EbonHawk") {
            $playerShip->chooseShip($playerShip,$this->getShips()->get(0));
        }
        if ($result === "Typhoon") {
            $playerShip->chooseShip($playerShip,$this->getShips()->get(1));
        }
        if ($result === "Cyclone") {
            $playerShip->chooseShip($playerShip,$this->getShips()->get(2));
        }




        $playerShip->showStats($this->cli);
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
        $this->addShip(new Ship(name: "Ebon Hawk", maxFuel: 100, maxHullIntegrity: 150, maxShields: 150, missileDamage: 80, laserDamage: 60));
        $this->addShip(new Ship(name: "Typhoon", maxFuel: 120, maxHullIntegrity: 200, maxShields: 100, missileDamage: 100, laserDamage: 60));
        $this->addShip(new Ship(name: "Cyclone", maxFuel: 80, maxHullIntegrity: 100, maxShields: 200, missileDamage: 70, laserDamage: 60));

    }

    private function addShip(Ship $ship)
    {
        $this->ships->add($ship);
    }

    function write(string $message)
    {
        $this->cli->out($message);
    }

    function info(string $message)
    {
        $this->cli->info($message);
    }
}
