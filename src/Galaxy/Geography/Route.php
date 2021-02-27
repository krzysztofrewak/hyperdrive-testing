<?php

declare(strict_types=1);

namespace Hyperdrive\Galaxy\Geography;

use Illuminate\Support\Collection;
use Symfony\Component\Config\Definition\Exception\Exception;

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
        $planet->setId($this->planets->count());
        $this->planets->add($planet);
    }

    public function createPlanet(string $name): Planet
    {
        $planet = new Planet($name);
        $this->addPlanet($planet);
        return $planet;
    }

    public function getPlanets(): Collection
    {
        return $this->planets;
    }

    /**
     * @throws Exception
     */
    public function getPlanetByName(string $name): Planet
    {
        /** @var Planet $planet */
        foreach ($this->planets as $planet) {
            if ($planet->__toString() === $name) {
                return $planet;
            }
        }
        throw new Exception("There is no planet with this name");
    }

    /**
     * @throws Exception
     */
    public function getPlanetById(int $id): Planet
    {
        if ($id >= 0 && $id < $this->planets->count()) {
            return $this->planets->get($id);
        }
        throw new Exception("There is no planet with this id");
    }
}
