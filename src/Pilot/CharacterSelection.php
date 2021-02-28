<?php

declare(strict_types=1);

namespace Hyperdrive\Pilot;

use Hyperdrive\Output\OutputContract;
use Hyperdrive\Ship\Ship;
use Illuminate\Support\Collection;


class CharacterSelection
{

    private Collection $pilots;
    private Collection $ships;
    protected OutputContract $output;


    public function __construct(OutputContract $output)
    {
        $this->output = $output;
        $this->pilots = collect();
        $this->ships = collect();
        $this->addPilots();
        $this->addShips();

    }


    private function addPilot(Pilot $pilot): void
    {
        $this->pilots->add($pilot);

    }

    private function addPilots(): void
    {
        $this->addPilot(new Pilot(output: $this->output, name: "Atton Rand", reputation: 5, skill: 5, credits: 3000, exp: 0));
        $this->addPilot(new Pilot(output: $this->output, name: "Jarrnes Corring", reputation: 3, skill: 3, credits: 3000, exp: 0));
        $this->addPilot(new Pilot(output: $this->output, name: "Garfinn Newdor", reputation: 1, skill: 2, credits: 3000, exp: 0));
    }

    private function addShip(Ship $ship)
    {
        $this->ships->add($ship);
    }

    private function addShips()
    {
        $this->addShip(new Ship(output: $this->output, name: "Ebon Hawk", maxFuel: 100, maxHullIntegrity: 150, maxShields: 150, missileDamage: 80, laserDamage: 60));
        $this->addShip(new Ship(output: $this->output, name: "Typhoon", maxFuel: 120, maxHullIntegrity: 200, maxShields: 100, missileDamage: 100, laserDamage: 60));
        $this->addShip(new Ship(output: $this->output, name: "Cyclone", maxFuel: 80, maxHullIntegrity: 100, maxShields: 200, missileDamage: 70, laserDamage: 60));

    }

    public function characterSelection(Pilot $player, Ship $playerShip): void
    {
        for ($i = 0; $i < $this->getPilots()->count(); $i++) {
            $this->output->write("");
            $this->output->info("Pilot #" . $i + 1);
            $this->output->write("Name: " . $this->getPilots()->get($i)->getName());
            $this->output->write("Reputation: " . $this->getPilots()->get($i)->getReputation() . " (More reputation = More difficulties)");
            $this->output->write("Skill: " . $this->getPilots()->get($i)->getSkill() . " (More skill = Easier Navigation)");
            $this->output->write("Credits: " . $this->getPilots()->get($i)->getCredits());
            $this->output->write("");
        }

        $options = ["Atton" => "I'm choosing Atton", "Jarrnes" => "I'm choosing Jarrnes", "Garfinn" => "I'm choosing Garfinn"];
        $result = $this->output->getCli()->radio("Choose your Pilot", $options)->prompt();

        if ($result === "Atton") {
            $player->choosePilot($player, $this->getPilots()->get(0));
        }
        if ($result === "Jarrnes") {
            $player->choosePilot($player, $this->getPilots()->get(1));
        }
        if ($result === "Garfinn") {
            $player->choosePilot($player, $this->getPilots()->get(2));
        }

        for ($i = 0; $i < $this->getShips()->count(); $i++) {
            $this->output->write("");
            $this->output->info("Ship #" . $i + 1);
            $this->output->write("Name: " . $this->getShips()->get($i)->getName());
            $this->output->write("Max Fuel: " . $this->getShips()->get($i)->getMaxFuel());
            $this->output->write("Max Shields " . $this->getShips()->get($i)->getMaxShields());
            $this->output->write("Max Hull Integrity " . $this->getShips()->get($i)->getMaxHullIntegrity());
            $this->output->write("Missile Damage: " . $this->getShips()->get($i)->getMissileDamage());
            $this->output->write("Laser Damage " . $this->getShips()->get($i)->getLaserDamage());
            $this->output->write("");
        }

        $options = ["EbonHawk" => "I'm choosing Ebon Hawk", "Typhoon" => "I'm choosing Typhoon", "Cyclone" => "I'm choosing Cyclone"];
        $result = $this->output->getCli()->radio("Choose your Ship", $options)->prompt();

        if ($result === "EbonHawk") {
            $playerShip->chooseShip($playerShip, $this->getShips()->get(0));
        }
        if ($result === "Typhoon") {
            $playerShip->chooseShip($playerShip, $this->getShips()->get(1));
        }
        if ($result === "Cyclone") {
            $playerShip->chooseShip($playerShip, $this->getShips()->get(2));
        }

        $playerShip->showStats();
    }


    public function getPilots(): Collection
    {
        return $this->pilots;
    }

    public function getShips(): Collection
    {
        return $this->ships;
    }

}
