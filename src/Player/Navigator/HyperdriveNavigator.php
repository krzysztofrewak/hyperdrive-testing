<?php

declare(strict_types=1);

namespace Hyperdrive\Player\Navigator;

use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Galaxy\Geography\Route;
use Symfony\Component\Config\Definition\Exception\Exception;

class HyperdriveNavigator
{
    protected ?Planet $currentPlanet;

    public function __construct(protected Route $route, protected int $hyperspaceJumpsLimit, protected bool $unlockedMap)
    {
    }

    public function unlockMap(): void
    {
        $this->unlockedMap = true;
    }

    public function getHyperspaceJumpsLimit(): int
    {
        return $this->hyperspaceJumpsLimit;
    }

    public function hyperspaceJumpTo(Planet $planet): void
    {
        --$this->hyperspaceJumpsLimit;
        $this->jumpTo($planet);
    }

    public function getCurrentPlanet(): ?Planet
    {
        return $this->currentPlanet;
    }

    public function jumpTo(Planet $planet): void
    {
        $this->currentPlanet = $planet;
    }

    public function getRandomPlanet(): Planet
    {
        $this->currentPlanet = $this->route->getRandomPlanet();
        return $this->currentPlanet;
    }

    /**
     * @throws Exception
     */
    public function getMap(): array
    {
        if (!$this->unlockedMap) {
            throw new Exception("You don't have a map");
        }
        return $this->route->getPlanets()->toArray();
    }

    public function getRoute(): Route
    {
        return $this->route;
    }
}
