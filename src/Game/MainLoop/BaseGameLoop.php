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
        $this->game->gameState = new GameState();
        $gameSave = (array)($this->game->gameSave);

        foreach ($this->game->gameState as &$record) {
            $record = current($gameSave);
            next($gameSave);
        }
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