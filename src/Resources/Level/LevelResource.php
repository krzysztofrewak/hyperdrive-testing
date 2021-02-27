<?php

declare(strict_types=1);

namespace Hyperdrive\Resources\Level;

use Hyperdrive\Level\Level;
use JetBrains\PhpStorm\ArrayShape;

class LevelResource
{
    #[ArrayShape([
        "Difficulty Level" => "string",
        "Fuel" => "int",
        "Capital" => "int",
        "Hyperspace Jumps Limit" => "int",
        "Unlocked Map" => "string",
    ])]
    public function __invoke(Level $level): array
    {
        return [
            "Difficulty Level" => $level->__toString(),
            "Fuel" => $level->getFuel(),
            "Capital" => $level->getCapital(),
            "Hyperspace Jumps Limit" => $level->getHyperspaceJumpsLimit(),
            "Unlocked Map" => $level->isUnlockedMap() ? "true" : "false",
        ];
    }
}
