<?php

declare(strict_types=1);

namespace Hyperdrive\Resources\PriceList;

use Hyperdrive\Player\Navigator\HyperspaceJumpOption;
use JetBrains\PhpStorm\ArrayShape;

class HyperspaceJumpResource extends BaseResource
{
    #[ArrayShape([
        "Name" => "string",
        "Price" => "int",
    ])]
    public function __invoke(HyperspaceJumpOption $hyperspaceJumpOption): array
    {
        $name = $hyperspaceJumpOption->__toString();
        $price = $hyperspaceJumpOption->getPrice();

        return $this->toArray($name, $price);
    }
}
