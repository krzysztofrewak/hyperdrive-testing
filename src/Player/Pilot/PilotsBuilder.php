<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Pilot;

use Hyperdrive\Contracts\BuilderContract;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

class PilotsBuilder implements BuilderContract
{
    protected function __construct()
    {
    }

    public static function buildFromArray(array $data): Collection
    {
        $pilots = collect();
        self::buildPilots($pilots, $data);

        return $pilots;
    }

    public static function buildFromYaml(string $filePath): Collection
    {
        $pilots = collect();
        $data = Yaml::parseFile($filePath);
        self::buildPilots($pilots, $data);

        return $pilots;
    }

    protected static function buildPilots(Collection &$collection, array $data): void
    {
        foreach ($data as $name) {
            $collection->add(new Pilot($name));
        }
    }
}
