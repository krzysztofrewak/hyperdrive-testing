<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\Geography\Planet;
use Hyperdrive\HyperdriveNavigator;

class GameAssetsBuilder
{
    private HyperdriveNavigator $hyperdrive;
    private array $planets = [];

    public function __construct()
    {
        $atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
        $this->hyperdrive = new HyperdriveNavigator($atlas);
        unset($atlas);
        $targetPlanet = $this->hyperdrive->getRandomPlanet();
        $startingPlanet = $this->hyperdrive->getRandomPlanet();
        // finish integrity ???
        $this->prepareAssetsIds($targetPlanet, $startingPlanet);
    }

    private function prepareAssetsIds(Planet $target, Planet $starting): void
    {
        array_push($this->planets, $target, $starting);
    }

    public function getAssetsIdsToSaveFile(): array
    {
        return $this->planets;
    }
}