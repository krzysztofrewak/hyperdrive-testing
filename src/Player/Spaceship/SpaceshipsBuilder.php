<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Spaceship;

use Hyperdrive\Contracts\BuilderContract;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

class SpaceshipsBuilder implements BuilderContract
{
    protected function __construct()
    {
    }

    public static function buildFromArray(array $data): Collection
    {
        $spaceships = collect();
        self::buildSpaceship($spaceships, $data);

        return $spaceships;
    }

    public static function buildFromYaml(string $filePath): Collection
    {
        $spaceships = collect();
        $data = Yaml::parseFile($filePath);
        self::buildSpaceship($spaceships, $data);

        return $spaceships;
    }

    protected static function buildSpaceship(Collection &$spaceships, array $data): void
    {
        foreach ($data as $name => $spaceshipData) {
            $spaceships->add(new Spaceship($spaceshipData + [
                "name" => $name,
            ]));
        }
    }
}
