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

    public static function buildRouteFromArray(array $data): Route
    {
        $route = new Route($data["name"]);

        /** @var Planet|null $previous */
        $previous = null;

        foreach ($data["planets"] as $planet) {
            $planet = $route->createPlanet($planet);
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
        $data = Yaml::parseFile($filePath);
        self::buildPlanets($galaxyAtlas, $data);

        return $galaxyAtlas;
    }

    protected static function buildPlanets(GalaxyAtlas &$galaxyAtlas, array $data): void
    {
        foreach ($data as $name => $planets) {
            $route = self::buildRouteFromArray([
                "name" => $name,
                "planets" => $planets,
            ]);
            $galaxyAtlas->addRoute($route);
        }
    }
}
