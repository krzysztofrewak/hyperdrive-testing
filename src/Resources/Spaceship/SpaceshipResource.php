<?php

declare(strict_types=1);

namespace Hyperdrive\Resources\Spaceship;

use Hyperdrive\Player\Spaceship\Spaceship;

class SpaceshipResource
{
    public function __invoke(Spaceship $spaceship): array
    {
        $tankResource = new TankResource();

        return [
            "Name" => $spaceship->__toString(),
        ] + $tankResource($spaceship->getTank());
    }
}
