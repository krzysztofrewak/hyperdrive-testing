<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Spaceship;

use Hyperdrive\Contracts\BuilderContract;
use Symfony\Component\Yaml\Yaml;

class SpaceshipsBuilder implements BuilderContract
{
    protected function __construct()
    {
    }

    public static function buildFromRoutesArray(array $data): SpaceshipsCollection
    {
        $spaceshipsCollection = new SpaceshipsCollection();
        self::buildSpaceship($spaceshipsCollection, $data);

        return $spaceshipsCollection;
    }

    public static function buildFromYaml(string $filePath): SpaceshipsCollection
    {
        $spaceshipsCollection = new SpaceshipsCollection();
        $spaceshipsData = Yaml::parseFile($filePath);
        self::buildSpaceship($spaceshipsCollection, $spaceshipsData);

        return $spaceshipsCollection;
    }

    protected static function buildSpaceship(SpaceshipsCollection &$spaceshipsCollection, array $spaceshipsData): void
    {
        foreach ($spaceshipsData as $spaceshipData) {
            $spaceshipsCollection->addSpaceship(new Spaceship($spaceshipData));
        }
    }
}
