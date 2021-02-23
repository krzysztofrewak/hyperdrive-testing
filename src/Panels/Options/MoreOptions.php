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
        "jump" => "string",
        "return" => "string",
        "quit" => "string",
    ])]
    public function __invoke(): array
    {
        return [
            "spaceship" => "Spaceship details",
            "player" => "Player details",
            "refueling" => "Refueling spaceship",
            "map" => "Planets list",
            "jump" => "Hyperspace jumps",
            "return" => "Return",
            "quit" => "Quit application",
        ];
    }
}
