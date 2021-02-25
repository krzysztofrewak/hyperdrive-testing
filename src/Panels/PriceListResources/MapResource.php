<?php

declare(strict_types=1);

namespace Hyperdrive\Panels\PriceListResources;

use JetBrains\PhpStorm\ArrayShape;

class MapResource extends BaseResource
{
    #[ArrayShape([
        "Name" => "string",
        "Price" => "int",
    ])]
    public function __invoke(int $mapPrice): array
    {
        return $this->toArray("Unlocking the map", $mapPrice);
    }
}
