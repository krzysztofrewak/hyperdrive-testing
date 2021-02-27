<?php

declare(strict_types=1);

namespace Hyperdrive\Level;

use Hyperdrive\Contracts\BuilderContract;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

class LevelsBuilder implements BuilderContract
{
    protected function __construct()
    {
    }

    public static function buildFromArray(array $data): Collection
    {
        $levels = collect();
        self::buildLevel($levels, $data);

        return $levels;
    }

    public static function buildFromYaml(string $filePath): Collection
    {
        $levels = collect();
        $data = Yaml::parseFile($filePath);
        self::buildLevel($levels, $data);

        return $levels;
    }

    protected static function buildLevel(Collection &$levels, array $data): void
    {
        foreach ($data as $name => $levelData) {
            $levels->add(new Level($levelData + [
                "name" => $name,
            ]));
        }
    }
}
