<?php

declare(strict_types=1);

namespace Hyperdrive\Assets;

use Hyperdrive\Geography\Planet;
use Illuminate\Support\Str;

/**
 * Class GalaxyAtlas
 * @package Hyperdrive
 * @var Planet[] $planets
 */
class GalaxyAtlas
{
    protected array $planets = [];

    public function createOrUpdatePlanet(string $name): Planet
    {
        if (isset($this->planets[Str::slug($name)])) {
            return $this->planets[Str::slug($name)];
        }

        return $this->planets[Str::slug($name)] = new Planet($name);
    }

    public function getRandomPlanet(): Planet
    {
        return $this->planets[array_rand($this->planets)];
    }

    public function getPlanet(string $planet): Planet
    {
        return $this->planets[Str::slug($planet)];
    }

    public function getPlanets(): array
    {
        return $this->planets;
    }
}
