<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Spaceship;

use Illuminate\Support\Collection;

/**
 * Class SpaceshipsCollection
 * @package Hyperdrive\Player\Spaceship
 * @var Spaceship[] $spaceships
 */
class SpaceshipsCollection
{
    protected Collection $spaceships;

    public function __construct()
    {
        $this->spaceships = collect();
    }

    public function addSpaceship(Spaceship $spaceship): void
    {
        $this->spaceships->add($spaceship);
    }

    public function toArray(): array
    {
        return $this->spaceships->toArray();
    }

    public function getSpaceshipsData(): array
    {
        $spaceshipsData = [];

        /** @var Spaceship $spaceship */
        foreach ($this->spaceships as $spaceship) {
            $spaceshipsData[] = $spaceship->getSpaceshipData();
        }
        return $spaceshipsData;
    }
}
