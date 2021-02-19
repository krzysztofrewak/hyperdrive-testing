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
        $pilotsData = Yaml::parseFile($filePath);
        self::buildPilots($pilots, $pilotsData);

        return $pilots;
    }

    protected static function buildPilots(Collection &$collection, array $pilotsData): void
    {
        foreach ($pilotsData as $pilotData) {
            $collection->add(new Pilot($pilotData));
        }
    }
}
