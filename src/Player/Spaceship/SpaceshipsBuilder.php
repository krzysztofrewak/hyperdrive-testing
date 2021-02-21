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

    public static function buildFromArray(array $data): SpaceshipsCollection
    {
        $spaceshipsCollection = new SpaceshipsCollection();
        self::buildSpaceship($spaceshipsCollection, $data);

        return $spaceshipsCollection;
    }

    public static function buildFromYaml(string $filePath): SpaceshipsCollection
    {
        $spaceshipsCollection = new SpaceshipsCollection();
        $data = Yaml::parseFile($filePath);
        self::buildSpaceship($spaceshipsCollection, $data);

        return $spaceshipsCollection;
    }

    protected static function buildSpaceship(SpaceshipsCollection &$spaceshipsCollection, array $data): void
    {
        foreach ($data as $name => $spaceshipData) {
            $spaceshipsCollection->addSpaceship(new Spaceship($spaceshipData + [
                "name" => $name,
            ]));
        }
    }
}
