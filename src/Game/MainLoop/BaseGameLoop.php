<?php

declare(strict_types=1);

namespace Hyperdrive\Game\MainLoop;

use Hyperdrive\GalaxyAtlas;
use Hyperdrive\Game\Game;
use Hyperdrive\Game\GameAssetsBuilder;
use Hyperdrive\Game\Mission;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Helpers\YamlBuilder;

class BaseGameLoop
{
    use YamlBuilder;

    protected Game $game;
    private MainLoopPauseMenu $pauseMenu;
    private Mission $mission;
    private GalaxyAtlas $atlas;
    private HyperdriveNavigator $hyperdrive;

    private function buildAssets(): void
    {
        $builder = new GameAssetsBuilder();
        $this->hyperdrive = $builder->getHyperdrive();
        $this->atlas = $builder->getAtlas();
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

        // do wyjebania
        $this->buildAssets();

        $this->loadSave();
        $this->loadMission();

        while (!$_SESSION['isMissionComplete']) {
            $this->game->play($this->mission);
        }
    }
}