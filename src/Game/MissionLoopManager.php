<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

trait MissionLoopManager
{
    use MissionLoopHandler;

    private Mission $mission;

    public function constructMissionLoop(Mission $mission): void
    {
        $this->mission = $mission;
    }

    public function startMissionLoop(): void
    {
        $this->createUniqueMissionHandler();

        $this->startLoop();

        $this->gameState->missionId = $_SESSION['nextMission'];
        $this->gameState->stage = 0;
        $this->saveGame();
    }

    protected function updateGameState(): void
    {
        $this->gameState->stage = $this->stageIndex + 1;
    }
}