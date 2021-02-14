<?php

declare(strict_types=1);

namespace Hyperdrive\Geography;


use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Quest\Quest;
use Hyperdrive\Quest\QuestLog;
use Hyperdrive\Ship\Ship;
use League\CLImate\CLImate;

class PlanetSurface
{

    private CLImate $cli;
    private bool $jobFound;

    public function __construct(CLImate $cli)
    {
        $this->cli = $cli;
    }


    public function whatToDo(HyperdriveNavigator $hyperdrive, Ship $playerShip, Pilot $player, QuestLog $questlog): void
    {
        while(true)
        {
            $options = ["Ship" => "Buy Ship Upgrades", "Repair" => "Repair Ship", "Fuel" => "Refuel the Ship", "Quest" => "Search for a new Job", "Questlog" => "Show Quests", "Leave" => "Leave Planet"];
            $result = $this->cli->radio("Select option", $options)->prompt();

            if ($result === "Ship") {
                $this->shipUpgrades($playerShip,$player);
            }
            if ($result === "Repair") {
                $this->repairShip($playerShip,$player);
            }
            if ($result === "Fuel") {
                $this->refuelShip($playerShip,$player);
            }
            if ($result === "Quest") {
                $this->searchForJob($questlog,$hyperdrive);
            }
            if ($result === "Questlog") {
                $questlog->showQuests($this->cli);
            }
            if ($result === "Leave") {
                $this->leavePlanet($hyperdrive,$playerShip);
                break;
            }
        }

    }

    private function leavePlanet(HyperdriveNavigator $hyperdrive,Ship $playerShip): void
    {
        $planet = $hyperdrive->getCurrentPlanet();

        $this->cli->info("You're on the $planet. You can jump to:");
        $this->cli->info("Remaining fuel: ".$playerShip->getFuel());

        $options = $planet->getNeighbours()->toArray();
        $result = $this->cli->radio("Select a planet to jump to:", $options)->prompt();
        $hyperdrive->jumpTo($playerShip,$result);
    }

    private function shipUpgrades(Ship $playerShip, Pilot $player): void
    {
        $this->cli->out("Welcome to the upgrade shop! Every upgrade costs 2000 Credits");
        $options = ["Hull" => "Hull", "Shields" => "Shields", "Missile" => "Missiles", "Laser" => "Lasers", "Fuel" => "Fuel Tanks"];
        $result = $this->cli->radio("What do you want to upgrade?", $options)->prompt();

        if ($result === "Hull") {
            $this->cli->out("Do want to upgrade your Hull Capacity from ".$playerShip->getMaxHullIntegrity()." to ".($playerShip->getMaxHullIntegrity()+20)."?");

            if($this->yesOrNo($player))
            {
                $playerShip->setMaxHullIntegrity($playerShip->getMaxHullIntegrity()+20);
                $playerShip->setHullIntegrity($playerShip->getHullIntegrity()+20);
                $playerShip->showStats($this->cli);
            }

        }


        if ($result === "Shields")
        {
            $this->cli->out("Do want to upgrade your Shields from ".$playerShip->getMaxShields()." to ".($playerShip->getMaxShields()+10)."?");

            if($this->yesOrNo($player))
            {
                    $playerShip->setMaxShields($playerShip->getMaxShields()+10);
                    $playerShip->setShields($playerShip->getShields()+10);
                    $playerShip->showStats($this->cli);
            }
        }


        if ($result === "Missile") {
            $this->cli->out("Do want to upgrade your Missile Damage from ".$playerShip->getMissileDamage()." to ".($playerShip->getMissileDamage()+10)."?");

            if($this->yesOrNo($player))
            {
                    $playerShip->setMissileDamage($playerShip->getMissileDamage()+10);
                    $playerShip->showStats($this->cli);
            }
        }

        if ($result === "Laser") {
            $this->cli->out("Do want to upgrade your Laser Damage from ".$playerShip->getLaserDamage()." to ".($playerShip->getLaserDamage()+10)."?");

            if($this->yesOrNo($player))
            {
                    $playerShip->setLaserDamage($playerShip->getLaserDamage()+10);
                    $playerShip->showStats($this->cli);
            }
        }

        if ($result === "Fuel") {
            $this->cli->out("Do want to upgrade your Fuel Capacity from ".$playerShip->getMaxFuel()." to ".($playerShip->getMaxFuel()+10)."?");

            if($this->yesOrNo($player))
            {
                    $playerShip->setMaxFuel($playerShip->getMaxFuel()+10);
                    $playerShip->showStats($this->cli);
            }
        }
    }

    private function yesOrNo(Pilot $player): bool
    {
        $options = ["Yes" => "Yes", "No" => "No"];
        $result = $this->cli->radio("Proceed with the upgrade?", $options)->prompt();

        if ($result === "Yes")
        {
            if($player->getCredits() >= 2000)
            {
                $this->cli->out("Upgrade Successful!");
                $player->payCredits(2000);
                return true;
            }
            if($player->getCredits() < 2000)
            {
                $this->cli->out("You lack sufficient funds for an upgrade");
                return false;
            }
        }
    }

    private function repairShip(Ship $playerShip, Pilot $player)
    {
        $repair = $playerShip->getMaxHullIntegrity() - $playerShip->getHullIntegrity();
        $repair = $repair * 10;
        $player->payCredits($repair);
        $playerShip->setHullIntegrity($playerShip->getMaxHullIntegrity());
    }

    private function refuelShip(Ship $playerShip, Pilot $player)
    {
        $refuel = $playerShip->getMaxFuel() - $playerShip->getFuel();
        $refuel = $refuel * 5;
        $player->payCredits($refuel);
        $playerShip->setFuel($playerShip->getMaxFuel());
    }

    private function searchForJob(QuestLog $questLog,HyperdriveNavigator $hyperdrive)
    {
        if(!$this->isJobFound())
        {
            $questLog->addQuest(new Quest(cargo: $questLog->getRandomCargo(), destination: $hyperdrive->getRandomPlanet(), completed: false, main: false, exp: 2500, reward: $questLog->generateReward()));
            $this->setJobFound(true);
        }

    }

    /**
     * @return bool
     */
    public function isJobFound(): bool
    {
        return $this->jobFound;
    }

    /**
     * @param bool $jobFound
     */
    public function setJobFound(bool $jobFound): void
    {
        $this->jobFound = $jobFound;
    }






}