<?php

declare(strict_types=1);

namespace Hyperdrive\Panels\Options;

use JetBrains\PhpStorm\ArrayShape;

class MoreOptions
{
    #[ArrayShape([
        "spaceship" => "string",
        "player" => "string",
        "refueling" => "string",
        "map" => "string",
        "return" => "string",
        "quit" => "string",
    ])]
    public function __invoke(): array
    {
        return [
            "spaceship" => "show spaceship details",
            "player" => "show player details",
            "refueling" => "refueling spaceship",
            "map" => "show planets list",
            "return" => "return",
            "quit" => "quit application",
        ];
    }
}
