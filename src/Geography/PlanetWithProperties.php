<?php

namespace Hyperdrive\Geography;

use Hyperdrive\PlanetProperties\Property;
use Illuminate\Support\Collection;

/**
 * Class PlanetWithProperties
 * @package Hyperdrive\Geography
 * @var Property[] $properties
 */
class PlanetWithProperties extends Planet
{
    private array $properties = [];

    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getName(): string
    {
        return $this->name;
    }
}