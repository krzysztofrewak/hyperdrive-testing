<?php

declare(strict_types=1);

namespace Hyperdrive\PriceList;

use Hyperdrive\Player\Navigator\HyperspaceJumpOption;
use Symfony\Component\Yaml\Yaml;

class PriceList
{
    protected const FilePath = "./resources/price-list.yaml";

    public static function getFuelValues(): array
    {
        $data = Yaml::parseFile(self::FilePath);
        return $data["Fuel"];
    }

    public static function getHyperspaceJumpOptions(): array
    {
        $data = Yaml::parseFile(self::FilePath);
        $hyperspaceJumpOptions = collect();

        foreach ($data["Hyperspace-jump"] as $name => $values) {
            $hyperspaceJumpOptions->add(new HyperspaceJumpOption($name, $values["distance"], $values["price"]));
        }

        return $hyperspaceJumpOptions->toArray();
    }

    public static function getMapPrice(): int
    {
        $data = Yaml::parseFile(self::FilePath);
        return $data["Map"]["price"];
    }
}
