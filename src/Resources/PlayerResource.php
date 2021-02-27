<?php

declare(strict_types=1);

namespace Hyperdrive\Resources;

use Hyperdrive\Player\Player;
use JetBrains\PhpStorm\ArrayShape;

class PlayerResource
{
    #[ArrayShape([
        "Name" => "string",
        "Capital" => "int",
        "Target Planet" => "string",
        "Current Planet" => "string",
        "Hyperspace Jumps Limit" => "int",
    ])]
    public function __invoke(Player $player): array
    {
        return [
            "Name" => $player->getPilot()->__toString(),
            "Capital" => $player->getCurrentCapital(),
            "Target Planet" => $player->getTargetPlanet()->__toString(),
            "Current Planet" => $player->getCurrentPlanet()->__toString(),
            "Hyperspace Jumps Limit" => $player->getRemainingJumpsInHyperspace(),
        ];
    }
}
