<?php

declare(strict_types=1);

namespace Hyperdrive\GalaxyAtlas;

use Hyperdrive\Contracts\BuilderContract;
use Hyperdrive\Geography\Planet;
use Symfony\Component\Yaml\Yaml;

class GalaxyAtlasBuilder implements BuilderContract
{
    protected function __construct()
    {
    }

    public static function buildFromRoutesArray(array $data): GalaxyAtlas
    {
        $galaxyAtlas = new GalaxyAtlas();
        self::buildPlanets($galaxyAtlas, $data);

        return $galaxyAtlas;
    }

    public static function buildFromYaml(string $filePath): GalaxyAtlas
    {
        $galaxyAtlas = new GalaxyAtlas();
        $routes = Yaml::parseFile($filePath);
        self::buildPlanets($galaxyAtlas, $routes);

        return $galaxyAtlas;
    }

    protected static function buildPlanets(GalaxyAtlas &$galaxyAtlas, array $routes): void
    {
        foreach ($routes as $planets) {
            /** @var Planet|null $previous */
            $previous = null;

            foreach ($planets as $planet) {
                $planet = $galaxyAtlas->createOrUpdatePlanet($planet);
                if ($previous !== null) {
                    $previous->addNeighbour($planet);
                    $planet->addNeighbour($previous);
                }
                $previous = $planet;
            }
        }
    }
}
