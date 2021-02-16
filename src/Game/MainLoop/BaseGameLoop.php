<?php

declare(strict_types=1);

namespace Hyperdrive\Game\MainLoop;

use Hyperdrive\Game\Game;
use Hyperdrive\Game\GameAssetsBuilder;

class BaseGameLoop
{
    protected GameAssetsBuilder $builder;
    private Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    protected function buildAssets(): void
    {
        $this->builder = new GameAssetsBuilder();
    }

    private function loadSave()
    {
        $this->player = $this->game->gameSave->player;
        $this->friend1 = $this->game->gameSave->friend1;
        $this->friend2 = $this->game->gameSave->friend2;
        $this->team = $this->game->gameSave->team;
        $this->money = $this->game->gameSave->money;
        $this->fuel = $this->game->gameSave->fuel;
        $this->currentPlanet = $this->game->gameSave->currentPlanet;
        $this->targetPlanet = $this->game->gameSave->targetPlanet;
        $this->missionId = $this->game->gameSave->missionId;
    }

    protected function loadMission(): void
    {
    }

    protected function startGame(): void
    {
        new MainLoopMenu();
    }
}