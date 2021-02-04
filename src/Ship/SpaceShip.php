<?php

declare(strict_types=1);

namespace Hyperdrive\Ship;

use Hyperdrive\Ship\Weapons\Bombs;
use Hyperdrive\Ship\Weapons\Fire;
use Hyperdrive\Ship\Weapons\Lasers;
use League\CLImate\CLImate;

class SpaceShip
{
    protected int $fuel;
    protected int $condition;
    protected int $power;
    protected string $itemToTransport;
    protected string $target;
    protected array $weapons = [];

    public function __construct()
    {
        $this->condition = 100;
        $this->fuel = 100;
        $this->power = rand(5,10);
        $this->addWeapons();
    }

    private function addWeapons(){
        array_push($this->weapons, new Bombs(rand(15,30),"bombing"));
        array_push($this->weapons, new Fire(rand(5,22),"firefly"));
        array_push($this->weapons, new Lasers(rand(22,40),"laser eye"));
    }

    public function __toString() : string
    {
        return "\nFuel: ".$this->getFuel()."\nCondition: ".$this->getCondition()."\n";
    }

    public function getInfo() {
        $cli = new CLImate();
        echo "\n-------------------------------------------------------\n";
        $cli->info("My space ship info:");
        return "Condition: ".$this->condition."\nPower: ".$this->power;
    }


    public function getFuel(): int
    {
        return $this->fuel;
    }

    public function setFuel(int $fuel): void
    {
        $this->fuel += $fuel;
    }

    public function getCondition(): int
    {
        return $this->condition;
    }

    public function setCondition(int $condition): void
    {
        $this->condition += $condition;
    }

    public function getItemToTransport(): string
    {
        return $this->itemToTransport;
    }

    public function setItemToTransport($itemToTransport): void
    {
        $this->itemToTransport = $itemToTransport;
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    public function getPower(): int
    {
        return $this->power;
    }

    public function setPower(int $power): void
    {
        $this->power = $power;
    }

    public function getWeaponsDMG(int $index)
    {
        return $this->weapons[$index]->getDmg();
    }

    public function getWeaponsName(int $index)
    {
        return $this->weapons[$index]->getName();
    }





}