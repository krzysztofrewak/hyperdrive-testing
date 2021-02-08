<?php

declare(strict_types=1);

namespace Hyperdrive\Game\MainLoop;

use Hyperdrive\Game\GameAssetsBuilder;

class BaseGameLoop
{
    protected GameAssetsBuilder $builder;

    protected function buildAssets(): void
    {
        $this->builder = new GameAssetsBuilder();
    }

    protected function loadMission(): void
    {
    }

    protected function startGame(): void
    {
        new MainLoopMenu();
    }
}