<?php

declare(strict_types=1);

namespace Hyperdrive\Galaxy\Geography;

use Illuminate\Support\Collection;

/**
 * Class Route
 * @package Hyperdrive\Galaxy\Geography
 * @var Planet[] $planets
 */
class Route
{
    protected Collection $planets;

    public function __construct(protected string $name)
    {
        $this->planets = collect();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getRandomPlanet(): Planet
    {
        return $this->planets->random();
    }

    public function addPlanet(Planet $planet): void
    {
        $this->planets->add($planet);
    }

    public function createOrUpdatePlanet(string $name): Planet
    {
        $planet = new Planet($name);
        $this->planets->add($planet);
        return $planet;
    }

    public function getPlanets(): Collection
    {
        return $this->planets;
    }

    public function getPlanetByName(string $name): Planet
    {
        foreach ($this->planets as $planet) {
            if ($planet->__toString() === $name) {
                return $planet;
            }
        }
    }
}
