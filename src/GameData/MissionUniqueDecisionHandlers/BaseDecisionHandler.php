<?php

declare(strict_types=1);

namespace Hyperdrive\GameData\MissionUniqueDecisionHandlers;

use Hyperdrive\Game\GameAssetsBuilder;
use Hyperdrive\Game\MainLoop\GameState;
use Hyperdrive\Game\MainLoop\MainLoopPauseMenu;
use Hyperdrive\Menu;

abstract class BaseDecisionHandler extends Menu
{
    protected GameState $state;
    protected bool $progress = false;
    protected MainLoopPauseMenu $pauseMenu;
    protected GameAssetsBuilder $builtAssets;

    public function init(): void
    {
        parent::__construct();

        $this->builtAssets = new GameAssetsBuilder();
        $this->pauseMenu = new MainLoopPauseMenu();
    }

    public function isProgressing(): bool
    {
        return $this->progress;
    }

    public function addOptions(string $decision, string $option): void
    {
        $this->options[$decision] = $option;
        asort($this->options);
    }

    public function clearOptions(): void
    {
        $this->options = [];
        $this->options["pause"] = "Pause game";
    }

    public function toggleProgress(): void
    {
        $this->progress = !$this->progress;
    }

    public function isSaveFlagSet(): bool
    {
        return $this->pauseMenu->getSaveFlagState();
    }

    public function setGameState(GameState &$state): void
    {
        $this->state = $state;
    }

    protected function toggleMissionEnd(string $nextMission): void
    {
        $_SESSION["nextMission"] = $nextMission;
        $_SESSION["isMissionComplete"] = true;
        $this->state->timeSpent += 100;
        $this->toggleProgress();
    }
}
