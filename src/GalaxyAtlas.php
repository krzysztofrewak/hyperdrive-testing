<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\Geography\PlanetWithProperties;
use Illuminate\Support\Str;

/**
 * Class GalaxyAtlas
 * @package Hyperdrive
 * @var PlanetWithProperties[] $planets
 */
class GalaxyAtlas
{
    protected array $planets = [];

    public function createOrUpdatePlanet(string $name): PlanetWithProperties
    {
        if (isset($this->planets[Str::slug($name)])) {
            return $this->planets[Str::slug($name)];
        }

        return $this->planets[Str::slug($name)] = new PlanetWithProperties($name);
    }

    public function getRandomPlanet(): PlanetWithProperties
    {
        return $this->planets[array_rand($this->planets)];
    }

    public function getPlanet(string $planet): PlanetWithProperties
    {
        return $this->planets[Str::slug($planet)];
    }
}
