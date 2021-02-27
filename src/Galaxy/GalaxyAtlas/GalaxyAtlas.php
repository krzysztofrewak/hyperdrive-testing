<?php

declare(strict_types=1);

namespace Hyperdrive\Galaxy\GalaxyAtlas;

use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Galaxy\Geography\Route;
use Illuminate\Support\Collection;

/**
 * Class GalaxyAtlas
 * @package Hyperdrive\Galaxy\GalaxyAtlas
 * @var Planet[] $routes
 */
class GalaxyAtlas
{
    protected Collection $routes;

    public function __construct()
    {
        $this->routes = collect();
    }

    public function addRoute(Route $route): void
    {
        $this->routes->add($route);
    }

    public function toArray(): array
    {
        return $this->routes->toArray();
    }
}
