<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Spaceship;

use Symfony\Component\Config\Definition\Exception\Exception;

class Tank
{
    protected int $fuel;
    protected int $capacity;
    protected int $fuelConsumption;
    protected int $fuelConsumed = 0;

    public function __construct(array $tankData)
    {
        $this->setTankData($tankData);
    }

    public function getFuelConsumed(): int
    {
        return $this->fuelConsumed;
    }

    public function setFuel(int $fuel): void
    {
        $this->fuel = $fuel;
    }

    public function isItFull(): bool
    {
        return $this->capacity === $this->fuel;
    }

    /**
     * @throws Exception
     */
    public function refueling(int $fillingRate): void
    {
        if ($this->fuel === $this->capacity) {
            throw new Exception("You have a full tank");
        }
        $this->fuel += $fillingRate;
    }

    /**
     * @throws Exception
     */
    public function fuelConsumption(): void
    {
        if ($this->fuel - $this->fuelConsumption < 0) {
            throw new Exception("You don't have enough fuel. You need to refuel");
        }
        $this->fuel -= $this->fuelConsumption;
        $this->fuelConsumed += $this->fuelConsumption;
    }

    public function getTankData(): array
    {
        $data = [
            "capacity" => $this->capacity,
            "fuelConsumption" => $this->fuelConsumption,
        ];

        if ($this->fuel === 0) {
            return $data;
        }
        return [
            "fuel" => $this->fuel,
        ] + $data;
    }

    private function setTankData(array $tankData): void
    {
        $this->fuel = 0;
        $this->capacity = $tankData["capacity"];
        $this->fuelConsumption = $tankData["fuelConsumption"];
    }
}
