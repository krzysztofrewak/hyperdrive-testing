<?php

declare(strict_types=1);

namespace Hyperdrive\Ship;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Hyperdrive\Pilot\Pilot;
use League\CLImate\CLImate;
use Nette\Utils\ArrayList;

class Ship
{
    private String $name;
    private int $fuel;
    private int $maxFuel;
    private int $hullIntegrity;
    private int $maxHullIntegrity;
    private int $shields;
    private int $maxShields;
    private int $missileDamage;
    private int $laserDamage;

    public function __construct(string $name, int $fuel, int $maxFuel, int $hullIntegrity, int $maxHullIntegrity, int $shields, int $maxShields, int $missileDamage, int $laserDamage)
    {
        $this->name = $name;
        $this->fuel = $fuel;
        $this->maxFuel = $maxFuel;
        $this->hullIntegrity = $hullIntegrity;
        $this->maxHullIntegrity = $maxHullIntegrity;
        $this->shields = $shields;
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

    public function chooseShip(Ship $playerShip, Ship $choice): void
    {
        $playerShip->setName($choice->getName());
        $playerShip->setFuel($choice->getFuel());
        $playerShip->setMaxFuel($choice->getFuel());
        $playerShip->setHullIntegrity($choice->getHullIntegrity());
        $playerShip->setMaxHullIntegrity($choice->getMaxHullIntegrity());
        $playerShip->setShields($choice->getShields());
        $playerShip->setMaxShields($choice->getMaxShields());
        $playerShip->setMissileDamage($choice->getMissileDamage());
        $playerShip->setLaserDamage($choice->getLaserDamage());
    }

    public function TakeAction(CLImate $cli, Collection $enemies)
    {
        for ($i = 0; $i < $enemies->count(); $i++)
        {
            if($enemies->get($i)->getHullIntegrity() > 0)
            {
                $cli->info("Enemy #" . $i);
                $cli->info("Shields:" . $enemies->get($i)->getShields());
                $cli->info("Hull Integrity:" . $enemies->get($i)->getHullIntegrity());
            }
        }

        $target = $cli->input("Which enemy do you want to target? (Please type the number)")->prompt();


        $options = ["Laser" => "Attack with lasers! (Deals ".$this->getLaserDamage()." damage)", "Missile" => "Attack with missiles! (Deals ".$this->getMissileDamage()." damage)"];
        $result = $cli->radio("How do you want to attack him?", $options)->prompt();

        if ($result === "Laser") {
            $this->playerAttacksWithLaser($enemies->get($target));

        }
        if ($result === "Missile") {
            $this->playerAttacksWithMissile($enemies->get($target));
        }
    }

    public function takeDamage(int $damage,bool $isLaser)
    {
        if($this->getShields()==0)
        {
            $this->setHullIntegrity(($this->getHullIntegrity()-$damage));
        }

        if($this->getShields()>0)
        {
            if(!$isLaser)
            {
                $damage = $damage/2;
            }

            if($damage>$this->getShields())
            {
                $damageToHull = $damage - $this->getShields();
                $this->setHullIntegrity(($this->getHullIntegrity()-$damageToHull));
            }

            $this->setShields(($this->getShields()-$damage));
        }

            if($this->getShields()<0)
            {
                $this->setShields(0);
            }
    }


    public function playerAttacksWithMissile(Ship $enemyShip)
    {
        $enemyShip->takeDamage($this->getMissileDamage(),false);
    }

    public function playerAttacksWithLaser(Ship $enemyShip)
    {
        $enemyShip->takeDamage($this->getLaserDamage(),true);
    }

    public function enemyAttacksPlayer(Ship $playerShip,CLImate $cli)
    {
        $result = rand(1,2);

        if($result == 1)
        {
            $playerShip->takeDamage($this->getLaserDamage(),true);
            $cli->out("Player was attacked by ".$this->getName()." for ".$this->getLaserDamage()." laser damage!");
        }
        if($result == 2)
        {
            $playerShip->takeDamage($this->getMissileDamage(),false);
            $cli->out("Player was attacked by ".$this->getName()." for ".$this->getMissileDamage()." missile damage! (Damage halved against shields)");
        }
    }

    public function loseFuel(int $fuelLost)
    {
        if($fuelLost < 0)
        {
            $fuelLost = 0;
        }
        $this->setFuel($this->getFuel() - $fuelLost);
    }

}