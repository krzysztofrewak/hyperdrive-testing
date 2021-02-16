<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

use Symfony\Component\Yaml\Yaml;

trait YamlBuilder
{
    private function buildFromYamlFile(string $path, array &$output): void
    {
        $yamlFile = Yaml::parseFile($path);
        foreach ($yamlFile as $record)
        {
            array_push($output, $record[0] . " - " .  $record[1]);
        }
    }
}