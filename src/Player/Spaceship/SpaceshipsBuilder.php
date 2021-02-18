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
        $spaceships = new SpaceshipsCollection();
        self::buildSpaceship($spaceships, $data);

        return $spaceships;
    }

    public static function buildFromYaml(string $filePath): SpaceshipsCollection
    {
        $spaceships = new SpaceshipsCollection();
        $spaceshipsData = Yaml::parseFile($filePath);
        self::buildSpaceship($spaceships, $spaceshipsData);

        return $spaceships;
    }

    protected static function buildSpaceship(SpaceshipsCollection &$spaceships, array $spaceshipsData): void
    {
        foreach ($spaceshipsData as $spaceshipData) {
            $spaceships->addSpaceship(new Spaceship($spaceshipData));
        }
    }
}
