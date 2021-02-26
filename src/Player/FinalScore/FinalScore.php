<?php

declare(strict_types=1);

namespace Hyperdrive\Player\FinalScore;

use Hyperdrive\Player\Capital\Capital;
use Hyperdrive\Player\Navigator\HyperdriveNavigator;
use Hyperdrive\Player\Spaceship\Spaceship;
use JetBrains\PhpStorm\ArrayShape;

class FinalScore
{
    public function __construct(protected Capital $capital, protected HyperdriveNavigator $hyperdriveNavigator, protected Spaceship $spaceship)
    {
    }

    #[ArrayShape([
        "Capital Spent" => "int",
        "Visited Planets" => "int",
        "Completed Hyperspace Jumps" => "int",
        "Fuel consumed" => "int",
    ])]
    public function getFinalScore(): array
    {
        return [
            "Capital Spent" => $this->capital->getCapitalSpent(),
            "Visited Planets" => $this->hyperdriveNavigator->getVisitedPlanets(),
            "Completed Hyperspace Jumps" => $this->hyperdriveNavigator->getCompletedHyperspaceJumps(),
            "Fuel consumed" => $this->spaceship->getFuelConsumed(),
        ];
    }
}
