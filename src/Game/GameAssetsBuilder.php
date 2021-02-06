<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\Geography\Planet;
use Hyperdrive\HyperdriveNavigator;

class GameAssetsBuilder
{
    private HyperdriveNavigator $hyperdrive;

    public function __construct()
    {
        $atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
        $this->hyperdrive = new HyperdriveNavigator($atlas);
        unset($atlas);
    }
}