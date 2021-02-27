<?php

declare(strict_types=1);

namespace Hyperdrive\Resources\Spaceship;

use Hyperdrive\Player\Spaceship\Spaceship;
use Illuminate\Support\Collection;

class SpaceshipCollectionResource
{
    public function __invoke(Collection $collection): array
    {
        $data = [];
        $spaceshipResource = new SpaceshipResource();

        /** @var Spaceship $spaceship */
        foreach ($collection as $spaceship) {
            $data[] = $spaceshipResource($spaceship);
        }

        return $data;
    }
}
