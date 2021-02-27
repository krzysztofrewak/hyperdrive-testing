<?php

declare(strict_types=1);

namespace Hyperdrive\Resources\PriceList;

use JetBrains\PhpStorm\ArrayShape;

abstract class BaseResource
{
    #[ArrayShape([
        "Name" => "string",
        "Price" => "int",
    ])]
    protected function toArray(string $name, int $price): array
    {
        return [
            "Name" => $name,
            "Price" => $price,
        ];
    }
}
