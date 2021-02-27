<?php

declare(strict_types=1);

namespace Hyperdrive\Resources\Spaceship;

use Hyperdrive\Player\Spaceship\Tank;

class TankResource
{
    public function __invoke(Tank $tank): array
    {
        $data = [
            "Capacity" => $tank->getCapacity(),
            "Fuel Consumption" => $tank->getFuelConsumption(),
        ];

        if ($tank->getFuel() === 0) {
            return $data;
        }

        return [
            "Fuel" => $tank->getFuel(),
        ] + $data;
    }
}
