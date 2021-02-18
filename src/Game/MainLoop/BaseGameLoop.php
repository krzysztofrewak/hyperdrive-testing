<?php

declare(strict_types=1);

namespace Hyperdrive\Game\MainLoop;

use Hyperdrive\Game\Game;
use Hyperdrive\Game\GameAssetsBuilder;
use Hyperdrive\Game\Mission;
use Hyperdrive\Game\MissionLoop;
use Hyperdrive\Traits\YamlBuilder;

class BaseGameLoop
{
    use YamlBuilder;

    protected GameAssetsBuilder $builder;
    protected Game $game;
    private MainLoopPauseMenu $pauseMenu;
    private Mission $mission;

    private function buildAssets(): void
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

    private function loadMission(): void
    {
        $mission = $this->loadMissionFromYamlFile($this->missionId);
        $this->mission = new Mission($mission, $this->missionId);
    }

    // move to inst
    protected function startGame(): void
    {
        $this->buildAssets();
        $this->loadSave();
        $this->loadMission();
        $missionLoop = new MissionLoop($this->mission);
        // move run to the game function
        $this->game->run($missionLoop);
        //$missionLoop->run($this->game);
    }
}