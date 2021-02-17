<?php

declare(strict_types=1);

namespace Hyperdrive\Contracts;

interface BuilderContract
{
    public static function buildFromRoutesArray(array $data);

    public static function buildFromYaml(string $filePath);
}
