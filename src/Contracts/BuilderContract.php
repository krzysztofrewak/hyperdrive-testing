<?php

declare(strict_types=1);

namespace Hyperdrive\Contracts;

interface BuilderContract
{
    public static function buildFromArray(array $data);

    public static function buildFromYaml(string $filePath);
}
