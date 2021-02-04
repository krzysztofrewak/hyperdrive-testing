<?php

declare(strict_types=1);

namespace Hyperdrive\Entity;


use Hyperdrive\Geography\SpaceShip;
use Hyperdrive\Ship\Weapon;
use League\CLImate\CLImate;

class Enemy
{
    protected int $power;
    protected int $condition;
    protected Weapon $weapon;

    public function __construct(int $power, int $condition, Weapon $weapon)
    {
        $this->power = $power;
        $this->condition = $condition;
        $this->weapon = $weapon;
    }


    public function __toString(): string
    {
        $cli = new CLImate();
        echo "\n----------------------------------\n";
        $cli->info("Enemy on way with");
        return "Power: ".$this->power. "\nCondition: ".$this->condition." \nWeapon: ".$this->weapon->show()."\n";
    }


    public function getPower(): int
    {
        return $this->power;
    }


    public function setPower(int $power): void
    {
        $this->power = $power;
    }


    public function getCondition(): int
    {
        return $this->condition;
    }

    public function setCondition(int $condition): void
    {
        $this->condition -= $condition;
    }

    public function getWeapon(): Weapon
    {
        return $this->weapon;
    }

    public function setWeapon($weapon): void
    {
        $this->weapon = $weapon;
    }



}