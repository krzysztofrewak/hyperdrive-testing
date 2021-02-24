<?php

declare(strict_types=1);

namespace Hyperdrive\Ship;

use Hyperdrive\Output\OutputContract;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;

class Ship
{
    private string $name;
    private int $fuel;
    private int $maxFuel;
    private int $hullIntegrity;
    private int $maxHullIntegrity;
    private int $shields;
    private int $maxShields;
    private int $missileDamage;
    private int $laserDamage;
    protected OutputContract $output;

    public function __construct(OutputContract $output, string $name, int $maxFuel, int $maxHullIntegrity, int $maxShields, int $missileDamage, int $laserDamage)
    {
        $this->output = $output;
        $this->name = $name;
        $this->fuel = $maxFuel;
        $this->maxFuel = $maxFuel;
        $this->hullIntegrity = $maxHullIntegrity;
        $this->maxHullIntegrity = $maxHullIntegrity;
        $this->shields = $maxShields;
        $this->maxShields = $maxShields;
        $this->missileDamage = $missileDamage;
        $this->laserDamage = $laserDamage;
    }

    public function getMaxFuel(): int
    {
        return $this->maxFuel;
    }

    public function setMaxFuel(int $maxFuel): void
    {
        $this->maxFuel = $maxFuel;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxHullIntegrity(): int
    {
        return $this->maxHullIntegrity;
    }

    public function setMaxHullIntegrity(int $maxHullIntegrity): void
    {
        $this->maxHullIntegrity = $maxHullIntegrity;
    }

    public function getMaxShields(): int
    {
        return $this->maxShields;
    }

    public function setMaxShields(int $maxShields): void
    {
        $this->maxShields = $maxShields;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFuel(): int
    {
        return $this->fuel;
    }

    public function setFuel(int $fuel): void
    {
        $this->fuel = $fuel;
    }

    public function getHullIntegrity(): int
    {
        return $this->hullIntegrity;
    }

    public function setHullIntegrity(int $hullIntegrity): void
    {
        $this->hullIntegrity = $hullIntegrity;
    }

    public function getShields(): int
    {
        return $this->shields;
    }

    public function setShields(int $shields): void
    {
        $this->shields = $shields;
    }

    public function getMissileDamage(): int
    {
        return $this->missileDamage;
    }

    public function setMissileDamage(int $missileDamage): void
    {
        $this->missileDamage = $missileDamage;
    }

    public function getLaserDamage(): int
    {
        return $this->laserDamage;
    }

    public function setLaserDamage(int $laserDamage): void
    {
        $this->laserDamage = $laserDamage;
    }

    public function checkFuel(): void
    {
        if ($this->getFuel() <= 10) {
            $this->output->write("Fuel levels low! Refuel at the earliest convenience!");
        }
        if ($this->getFuel() <= 0) {
            $this->output->info("Fuel depleted! If only you haven't forgot to refuel the ship...");
            $this->output->info("Now you are destined to float through the space without an end... ");
            $this->output->info("Your journey has come to an end.");
        }
    }

    public function showStats(): void
    {
        $this->output->info("Your ship:");
        $this->output->write("Name: " . $this->getName());
        $this->output->write("Max Fuel: " . $this->getMaxFuel());
        $this->output->write("Max Shields " . $this->getMaxShields());
        $this->output->write("Max Hull Integrity " . $this->getMaxHullIntegrity());
        $this->output->write("Missile Damage: " . $this->getMissileDamage());
        $this->output->write("Laser Damage " . $this->getLaserDamage());
    }

    public function chooseShip(Ship $playerShip, Ship $choice): void
    {
        $playerShip->setName($choice->getName());
        $playerShip->setFuel($choice->getFuel());
        $playerShip->setMaxFuel($choice->getMaxFuel());
        $playerShip->setHullIntegrity($choice->getHullIntegrity());
        $playerShip->setMaxHullIntegrity($choice->getMaxHullIntegrity());
        $playerShip->setShields($choice->getShields());
        $playerShip->setMaxShields($choice->getMaxShields());
        $playerShip->setMissileDamage($choice->getMissileDamage());
        $playerShip->setLaserDamage($choice->getLaserDamage());
    }

    public function TakeAction(Collection $enemies)
    {
        for ($i = 0; $i < $enemies->count(); $i++) {
            if ($enemies->get($i)->getHullIntegrity() > 0) {
                $this->output->info("Enemy #" . $i+1);
                $this->output->info("Shields:" . $enemies->get($i)->getShields());
                $this->output->info("Hull Integrity:" . $enemies->get($i)->getHullIntegrity());
            }
        }

        $target = $this->output->input("Which enemy do you want to target? (Please type the number)");


        $options = ["Laser" => "Attack with lasers! (Deals " . $this->getLaserDamage() . " damage)", "Missile" => "Attack with missiles! (Deals " . $this->getMissileDamage() . " damage)"];
        $result = $this->output->getCli()->radio("How do you want to attack him?", $options)->prompt();

        if ($result === "Laser") {
            $this->playerAttacksWithLaser($enemies->get($target-1));

        }
        if ($result === "Missile") {
            $this->playerAttacksWithMissile($enemies->get($target-1));
        }
    }

    public function takeDamage(int $damage, bool $isLaser)
    {
        if ($this->getShields() == 0) {
            $this->setHullIntegrity(($this->getHullIntegrity() - $damage));
        }

        if ($this->getShields() > 0) {
            if (!$isLaser) {
                $damage = $damage / 2;
            }

            if ($damage > $this->getShields()) {
                $damageToHull = $damage - $this->getShields();
                $this->setHullIntegrity(($this->getHullIntegrity() - $damageToHull));
            }

            $this->setShields(($this->getShields() - $damage));
        }

        if ($this->getShields() < 0) {
            $this->setShields(0);
        }
    }


    public function playerAttacksWithMissile(Ship $enemyShip)
    {
        $enemyShip->takeDamage($this->getMissileDamage(), false);
    }

    public function playerAttacksWithLaser(Ship $enemyShip)
    {
        $enemyShip->takeDamage($this->getLaserDamage(), true);
    }

    public function enemyAttacksPlayer(Ship $playerShip): void
    {
        $result = rand(1, 2);
        if ($result == 1) {
            $playerShip->takeDamage($this->getLaserDamage(), true);
            $this->output->write("Player was attacked by " . $this->getName() . " for " . $this->getLaserDamage() . " laser damage!");
        }
        if ($result == 2) {
            $playerShip->takeDamage($this->getMissileDamage(), false);
            $this->output->write("Player was attacked by " . $this->getName() . " for " . $this->getMissileDamage() . " missile damage! (Damage halved against shields)");
        }
    }

    public function loseFuel(int $fuelLost)
    {
        if ($fuelLost < 0) {
            $fuelLost = 0;
        }
        $this->setFuel($this->getFuel() - $fuelLost);
    }

}