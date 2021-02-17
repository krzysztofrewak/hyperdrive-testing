<?php

declare(strict_types=1);

namespace Hyperdrive\Player;

use Hyperdrive\Geography\Planet;
use Hyperdrive\Navigator\HyperdriveNavigator;
use Hyperdrive\Player\Pilot\Pilot;
use JetBrains\PhpStorm\Pure;

class Player
{
    protected Pilot $pilot;
    protected Planet $targetPlanet;
    protected Planet $currentPlanet;
    protected HyperdriveNavigator $navigator;

    public function __construct(Pilot $pilot, HyperdriveNavigator $navigator)
    {
        $this->pilot = $pilot;
        $this->navigator = $navigator;
        $this->targetPlanet = $this->navigator->getRandomPlanet();
        $this->currentPlanet = $this->navigator->getRandomPlanet();
    }

    #[Pure]
    public function getName(): string
    {
        return $this->pilot->__toString();
    }

    public function getTargetPlanet(): Planet
    {
        return $this->targetPlanet;
    }

    public function getCurrentPlanet(): Planet
    {
        return $this->currentPlanet;
    }

    public function checkPlanetsEquals(): bool
    {
        return $this->currentPlanet === $this->targetPlanet;
    }

    public function jumpToPlanet(Planet $planet): void
    {
        $this->navigator->jumpTo($planet);
        $this->currentPlanet = $this->navigator->getCurrentPlanet();
    }
}
