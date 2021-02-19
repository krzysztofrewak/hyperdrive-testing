<?php

declare(strict_types=1);

namespace Hyperdrive\Galaxy\GalaxyAtlas;

use Hyperdrive\Contracts\BuilderContract;
use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Galaxy\Geography\Route;
use Symfony\Component\Yaml\Yaml;

class GalaxyAtlasBuilder implements BuilderContract
{
    protected function __construct()
    {
    }

    public static function buildFromArray(array $data): GalaxyAtlas
    {
        $galaxyAtlas = new GalaxyAtlas();
        self::buildPlanets($galaxyAtlas, $data);

        return $galaxyAtlas;
    }

    public static function buildRouteFromArray(array $routeData): Route
    {
        $route = new Route($routeData["name"]);

        /** @var Planet|null $previous */
        $previous = null;

        foreach ($routeData["planets"] as $planet) {
            $planet = $route->createOrUpdatePlanet($planet);
            if ($previous !== null) {
                $previous->addNeighbour($planet);
                $planet->addNeighbour($previous);
            }
            $previous = $planet;
        }

        return $route;
    }

    public static function buildFromYaml(string $filePath): GalaxyAtlas
    {
        $galaxyAtlas = new GalaxyAtlas();
        $routesData = Yaml::parseFile($filePath);
        self::buildPlanets($galaxyAtlas, $routesData);

        return $galaxyAtlas;
    }

    protected static function buildPlanets(GalaxyAtlas &$galaxyAtlas, array $routesData): void
    {
        foreach ($routesData as $routeData) {
            $route = self::buildRouteFromArray($routeData);
            $galaxyAtlas->addRoute($route);
        }
    }
}
