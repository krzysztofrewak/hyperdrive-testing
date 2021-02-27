<?php

declare(strict_types=1);

namespace Hyperdrive\Panels\Options;

use Hyperdrive\PriceList\PriceList;

class HyperspaceJumpOptions
{
    public function __invoke(): array
    {
        return PriceList::getHyperspaceJumpOptions() + [
            "quit" => "Quit",
        ];
    }
}
