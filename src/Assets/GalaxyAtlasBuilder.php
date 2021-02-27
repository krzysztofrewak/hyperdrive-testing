<?php

declare(strict_types=1);

namespace Hyperdrive\Assets;

use Symfony\Component\Yaml\Yaml;

class GalaxyAtlasBuilder
{
    protected function __construct()
    {
    }

    public static function buildFromRoutesArray(array $routes): GalaxyAtlas
    {
        $atlas = new GalaxyAtlas();
        self::buildPlanets($atlas, $routes);

        return $atlas;
    }

    public static function buildFromYaml(string $filePath): GalaxyAtlas
    {
        $atlas = new GalaxyAtlas();
        $routes = Yaml::parseFile($filePath);
        self::buildPlanets($atlas, $routes);

        return $atlas;
    }

    protected static function buildPlanets(GalaxyAtlas &$atlas, array $routes): void
    {
        $planets = $routes['galaxy'];
        $planetsCount = sizeof($planets);


        for ($i = 0; $i < $planetsCount; $i += 2) {
            $planet = &$planets[$i];
            $neighbours = $planets[$i + 1]["neighbours"];

            $planet = $atlas->createOrUpdatePlanet($planet);


            foreach ($neighbours as $neighbour) {
                $neighbour = $atlas->createOrUpdatePlanet($neighbour);

                if (!$planet->getNeighbours()->contains($neighbour->getId())) {
                    $planet->addNeighbour($neighbour);
                    $neighbour->addNeighbour($planet);
                }
            }
        }
    }
}
