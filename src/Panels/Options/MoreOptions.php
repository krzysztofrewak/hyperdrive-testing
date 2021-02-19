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
        "return" => "string",
        "quit" => "string",
    ])]
    public function __invoke(): array
    {
        return [
            "spaceship" => "show spaceship details",
            "player" => "show player details",
            "refueling" => "refueling Spaceship",
            "return" => "return",
            "quit" => "quit application",
        ];
    }
}
