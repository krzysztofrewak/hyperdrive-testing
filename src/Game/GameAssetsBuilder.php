<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GalaxyAtlas;
use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\HyperdriveNavigator;

class GameAssetsBuilder
{
    private HyperdriveNavigator $hyperdrive;
    private GalaxyAtlas $atlas;

    public function __construct()
    {
        $this->atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
        $this->hyperdrive = new HyperdriveNavigator($this->atlas);
    }

    public function getAtlas(): GalaxyAtlas
    {
        return $this->atlas;
    }

    public function getHyperdrive(): HyperdriveNavigator
    {
        return $this->hyperdrive;
    }
}