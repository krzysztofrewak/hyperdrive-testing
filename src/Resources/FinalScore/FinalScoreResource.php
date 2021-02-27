<?php

declare(strict_types=1);

namespace Hyperdrive\Resources\FinalScore;

use JetBrains\PhpStorm\ArrayShape;

class FinalScoreResource
{
    #[ArrayShape([
        "Name" => "string",
        "Value" => "int",
    ])]
    public function __invoke(string $name, int $value): array
    {
        return [
            "Name" => $name,
            "Value" => $value,
        ];
    }
}
