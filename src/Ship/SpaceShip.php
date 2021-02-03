<?php

declare(strict_types=1);

namespace Hyperdrive\Ship;

class SpaceShip
{
    protected int $fuel;
    protected int $condition;
    protected int $power;
    protected string $itemToTransport;
    protected string $target;

    public function __construct()
    {
        $this->condition = 100;
        $this->fuel = 100;
    }


    public function __toString() : string
    {
        return "\nFuel: ".$this->getFuel()."\nCondition: ".$this->getCondition()."\n";
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


}