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
        $atlas = new GalaxyAtlas();
        self::buildPlanets($atlas, $data);

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
        foreach ($routes as $planets) {
            /** @var Planet|null $previous */
            $previous = null;

            foreach ($planets as $planet) {
                $planet = $atlas->createOrUpdatePlanet($planet);
                if ($previous) {
                    $previous->addNeighbour($planet);
                    $planet->addNeighbour($previous);
                }
                $previous = $planet;
            }
        }
    }
}
