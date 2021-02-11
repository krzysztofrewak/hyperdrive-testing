<?php

declare(strict_types=1);

namespace Hyperdrive\Geography;

use Illuminate\Support\Collection;

/**
 * Class Route
 * @package Hyperdrive\Geography
 * @var Planet[] $planets
 */
class Route
{
    protected Collection $planets;

    public function __construct(protected string $name)
    {
        $this->planets = collect();
    }

    public function addPlanet(Planet $planet): void
    {
        $this->planets->add($planet);
    }

    public function getPlanets(): Collection
    {
        return $this->planets;
    }
}
