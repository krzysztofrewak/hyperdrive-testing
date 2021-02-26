<?php

declare(strict_types=1);

namespace Hyperdrive\Resources\PriceList;

use JetBrains\PhpStorm\ArrayShape;

class FuelResource extends BaseResource
{
    #[ArrayShape([
        "Name" => "string",
        "Price" => "int",
    ])]
    public function __invoke(array $fuelValues): array
    {
        $name = "Fuel - capacity: {$fuelValues["capacity"]}";
        $price = $fuelValues["price"];

        return $this->toArray($name, $price);
    }
}
