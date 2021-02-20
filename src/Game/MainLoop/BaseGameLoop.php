<?php

declare(strict_types=1);

namespace Hyperdrive\Game\MainLoop;

use Hyperdrive\Game\Game;
use Hyperdrive\Game\GameAssetsBuilder;
use Hyperdrive\Game\Mission;
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
        //foreach
        $this->game->gameState = new GameState();
        $this->game->gameState->player = (array)$this->game->gameSave->player;
        $this->game->gameState->friend1 = (array)$this->game->gameSave->friend1;
        $this->game->gameState->friend2 = (array)$this->game->gameSave->friend2;
        $this->game->gameState->money = $this->game->gameSave->money;
        $this->game->gameState->fuel = $this->game->gameSave->fuel;
        $this->game->gameState->team = (string)$this->game->gameSave->team;
        $this->game->gameState->currentPlanet = $this->game->gameSave->currentPlanet;
        $this->game->gameState->targetPlanet = $this->game->gameSave->targetPlanet;
        $this->game->gameState->missionId = $this->game->gameSave->missionId;
        $this->game->gameState->stage = $this->game->gameSave->stage;
    }

    private function loadMission(): void
    {
        $mission = $this->loadMissionFromYamlFile($this->game->gameState->missionId);
        $this->mission = new Mission($mission, $this->game->gameState->missionId);
    }

    protected function startGame(): void
    {
        $_SESSION['isMissionComplete'] = false;

        $this->buildAssets();
        $this->loadSave();
        $this->loadMission();

        while (!$_SESSION['isMissionComplete']) {
            $this->game->play($this->mission);
        }
    }
}