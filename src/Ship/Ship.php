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
    private int $hullIntegrity;
    private int $shields;
    private int $missileDamage;
    private int $laserDamage;

    /**
     * Ship constructor.
     * @param String $name
     * @param int $fuel
     * @param int $hullIntegrity
     * @param int $shields
     * @param int $missileDamage
     * @param int $laserDamage
     */
    public function __construct(string $name, int $fuel, int $hullIntegrity, int $shields, int $missileDamage, int $laserDamage)
    {
        $this->name = $name;
        $this->fuel = $fuel;
        $this->hullIntegrity = $hullIntegrity;
        $this->shields = $shields;
        $this->missileDamage = $missileDamage;
        $this->laserDamage = $laserDamage;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getFuel(): int
    {
        return $this->fuel;
    }

    /**
     * @param int $fuel
     */
    public function setFuel(int $fuel): void
    {
        $this->fuel = $fuel;
    }

    /**
     * @return int
     */
    public function getHullIntegrity(): int
    {
        return $this->hullIntegrity;
    }

    /**
     * @param int $hullIntegrity
     */
    public function setHullIntegrity(int $hullIntegrity): void
    {
        $this->hullIntegrity = $hullIntegrity;
    }

    /**
     * @return int
     */
    public function getShields(): int
    {
        return $this->shields;
    }

    /**
     * @param int $shields
     */
    public function setShields(int $shields): void
    {
        $this->shields = $shields;
    }

    /**
     * @return int
     */
    public function getMissileDamage(): int
    {
        return $this->missileDamage;
    }

    /**
     * @param int $missileDamage
     */
    public function setMissileDamage(int $missileDamage): void
    {
        $this->missileDamage = $missileDamage;
    }

    /**
     * @return int
     */
    public function getLaserDamage(): int
    {
        return $this->laserDamage;
    }

    /**
     * @param int $laserDamage
     */
    public function setLaserDamage(int $laserDamage): void
    {
        $this->laserDamage = $laserDamage;
    }

    public function TakeAction(CLImate $cli, Collection $enemies)
    {
        for ($i = 0; $i < $enemies->count(); $i++)
        {
            //player chooses who to attack
            //attack A - Laser
            //attack B - Missile
            //check health of an enemy etc
        }
    }

    public function TakeDamage(int $damage,bool $isLaser)
    {
        if($this->getShields()==0)
        {
            $this->setHullIntegrity(($this->getHullIntegrity()-$damage));
        }


        if($this->getShields()>0)
        {
            if($isLaser)
            {
                $this->setShields(($this->getShields()-$damage));

            }
            if(!$isLaser)
            {
                $damage = $damage/2;
                $this->setShields(($this->getShields()-$damage));
            }

            if($this->getShields()<0)
            {
                $this->setShields(0);

            }
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

    public function enemyAttacksPlayer(Ship $playerShip)
    {
        $result = rand(1,2);

        if($result == 1)
        {
            //"Enemy attacks Player with laser"
            $playerShip->takeDamage($this->getLaserDamage(),true);
        }
        if($result == 2)
        {
            //"Enemy attacks Player with missile"
            $playerShip->takeDamage($this->getMissileDamage(),false);
        }
    }


}