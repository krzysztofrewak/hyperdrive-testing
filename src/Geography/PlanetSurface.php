<?php

declare(strict_types=1);

namespace Hyperdrive\Geography;


use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Output\OutputContract;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Quest\Quest;
use Hyperdrive\Quest\QuestLog;
use Hyperdrive\Ship\Ship;

class PlanetSurface
{

    private bool $jobFound = false;
    protected OutputContract $output;

    public function __construct(OutputContract $output)
    {
        $this->output = $output;
    }

    public function payToll(Pilot $player):void
    {
        $toll = $player->calculateToll();
        $this->output->info("You had to pay $toll credits in order to land on the planet");
        $player->payCredits($toll);
    }

    public function whatToDo(Pilot $player, Ship $playerShip, HyperdriveNavigator $hyperdrive, QuestLog $questlog): void
    {

        while (true) {
            $options = ["Ship" => "Buy Ship Upgrades", "stats" => "Show Pilot and Ship Stats", "quests" => "Show Quests", "Repair" => "Repair Ship", "Fuel" => "Refuel the Ship", "Quest" => "Search for a new Job", "Questlog" => "Show Quests", "Leave" => "Leave Planet"];
            $result = $this->output->getCli()->radio("Select option", $options)->prompt();

            if ($result === "Ship") {
                $this->shipUpgrades($playerShip, $player);
            }
            if ($result === "stats") {
                $player->showStats();
                $playerShip->showStats();
            }
            if ($result === "quests") {
                $questlog->showQuests();
            }
            if ($result === "Repair") {
                $this->repairShip($playerShip, $player);
            }
            if ($result === "Fuel") {
                $this->refuelShip($playerShip, $player);
            }
            if ($result === "Quest") {
                $this->searchForJob($questlog, $hyperdrive);
            }
            if ($result === "Leave") {
                $this->leavePlanet($hyperdrive, $playerShip);
                break;
            }
        }

    }

    private function leavePlanet(HyperdriveNavigator $hyperdrive, Ship $playerShip): void
    {
        $planet = $hyperdrive->getCurrentPlanet();
        $this->output->write("");
        $this->output->info("You're on the $planet. You can jump to:");
        $this->output->info("Remaining fuel: " . $playerShip->getFuel());

        $options = $planet->getNeighbours()->toArray();
        $result = $this->output->getCli()->radio("Select a planet to jump to:", $options)->prompt();
        $hyperdrive->jumpTo($playerShip, $result);
    }

    private function shipUpgrades(Ship $playerShip, Pilot $player): void
    {
        $this->output->write("");
        $this->output->write("Welcome to the upgrade shop! Each upgrade costs 2000 Credits");
        $player->showCredits();
        $options = ["Hull" => "Hull", "Shields" => "Shields", "Missile" => "Missiles", "Laser" => "Lasers", "Fuel" => "Fuel Tanks","Return" => "Return"];
        $result = $this->output->getCli()->radio("What do you want to upgrade?", $options)->prompt();

        if ($result === "Hull") {
            $this->output->write("Do want to upgrade your Hull Capacity from " . $playerShip->getMaxHullIntegrity() . " to " . ($playerShip->getMaxHullIntegrity() + 20) . "?");

            if ($this->yesOrNo($player)) {
                $playerShip->setMaxHullIntegrity($playerShip->getMaxHullIntegrity() + 20);
                $playerShip->setHullIntegrity($playerShip->getHullIntegrity() + 20);
                $playerShip->showStats();
            }

        }


        if ($result === "Shields") {
            $this->output->write("Do want to upgrade your Shields from " . $playerShip->getMaxShields() . " to " . ($playerShip->getMaxShields() + 10) . "?");

            if ($this->yesOrNo($player)) {
                $playerShip->setMaxShields($playerShip->getMaxShields() + 10);
                $playerShip->setShields($playerShip->getShields() + 10);
                $playerShip->showStats();
            }
        }


        if ($result === "Missile") {
            $this->output->write("Do want to upgrade your Missile Damage from " . $playerShip->getMissileDamage() . " to " . ($playerShip->getMissileDamage() + 10) . "?");

            if ($this->yesOrNo($player)) {
                $playerShip->setMissileDamage($playerShip->getMissileDamage() + 10);
                $playerShip->showStats();
            }
        }

        if ($result === "Laser") {
            $this->output->write("Do want to upgrade your Laser Damage from " . $playerShip->getLaserDamage() . " to " . ($playerShip->getLaserDamage() + 10) . "?");

            if ($this->yesOrNo($player)) {
                $playerShip->setLaserDamage($playerShip->getLaserDamage() + 10);
                $playerShip->showStats();
            }
        }

        if ($result === "Fuel") {
            $this->output->write("Do want to upgrade your Fuel Capacity from " . $playerShip->getMaxFuel() . " to " . ($playerShip->getMaxFuel() + 10) . "?");

            if ($this->yesOrNo($player)) {
                $playerShip->setMaxFuel($playerShip->getMaxFuel() + 10);
                $playerShip->showStats();
            }
        }
    }

    private function yesOrNo(Pilot $player): bool
    {
        $options = ["Yes" => "Yes", "No" => "No"];
        $result = $this->output->getCli()->radio("Proceed with the upgrade?", $options)->prompt();

        if ($result === "Yes") {
            if ($player->getCredits() >= 2000) {
                $this->output->write("Upgrade Successful!");
                $player->payCredits(2000);
                return true;
            }
            if ($player->getCredits() < 2000) {
                $this->output->write("You lack sufficient funds for an upgrade");
                return false;
            }
        } else{
            return false;
        }
    }

    private function repairShip(Ship $playerShip, Pilot $player)
    {
        $repair = $playerShip->getMaxHullIntegrity() - $playerShip->getHullIntegrity();
        $repair = $repair * 10;
        if($player->getCredits()>=$repair){
            $player->payCredits($repair);
            $playerShip->setHullIntegrity($playerShip->getMaxHullIntegrity());
            $this->output->write("Ship has been repaired for $repair credits.");
            $player->showCredits();
        } else{
            $this->output->write("You lack sufficient funds for a repair.");
        }

    }

    private function refuelShip(Ship $playerShip, Pilot $player)
    {
        $refuel = $playerShip->getMaxFuel() - $playerShip->getFuel();
        $refuel = $refuel * 5;
        if($player->getCredits()>=$refuel){
        $player->payCredits($refuel);
        $playerShip->setFuel($playerShip->getMaxFuel());
        $this->output->write("Ship has been refueled for $refuel credits.");
        $player->showCredits();
        } else{
            $this->output->write("You lack sufficient funds for a refuel.");
        }
    }

    private function searchForJob(QuestLog $questLog, HyperdriveNavigator $hyperdrive)
    {
        $this->output->write("");
        if (!$this->isJobFound()) {
            $this->output->info("You found an additional job.");
            $questLog->addQuest(new Quest(cargo: $questLog->getRandomCargo(), destination: $hyperdrive->getRandomPlanet(), completed: false, main: false, exp: 2500, reward: $questLog->generateReward()));
            $this->setJobFound(true);
        } else {
            $this->output->info("You couldn't find additional jobs.");
        }
    }

    public function isJobFound(): bool
    {
        return $this->jobFound;
    }

    public function setJobFound(bool $jobFound): void
    {
        $this->jobFound = $jobFound;
    }

}