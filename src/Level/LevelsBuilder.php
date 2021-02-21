<?php

declare(strict_types=1);

namespace Hyperdrive\Level;

use Hyperdrive\Contracts\BuilderContract;
use Symfony\Component\Yaml\Yaml;

class LevelsBuilder implements BuilderContract
{
    public static function buildFromArray(array $data): LevelsCollection
    {
        $levelsCollection = new LevelsCollection();
        self::buildSpaceship($levelsCollection, $data);

        return $levelsCollection;
    }

    public static function buildFromYaml(string $filePath): LevelsCollection
    {
        $levelsCollection = new LevelsCollection();
        $data = Yaml::parseFile($filePath);
        self::buildSpaceship($levelsCollection, $data);

        return $levelsCollection;
    }

    protected static function buildSpaceship(LevelsCollection &$levelsCollection, array $data): void
    {
        foreach ($data as $name => $levelData) {
            $levelsCollection->addLevel(new Level($levelData + [
                "name" => $name,
            ]));
        }
    }
}
