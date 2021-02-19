<?php

declare(strict_types=1);

namespace Hyperdrive\Panels\Options;

use Hyperdrive\Player\Player;

class MainOptions
{
    public function __invoke(Player $player): array
    {
        return $player->getCurrentPlanet()->getNeighbours()->toArray() + [
            "more" => "[show more option]",
        ];
    }
}
