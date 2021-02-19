<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use League\CLImate\CLImate;

trait MissionLoopT
{
    use MissionLoopHandler;

    private Mission $mission;

    public function constructMissionLoop(Mission $mission)
    {
        $this->cli = new CLImate();
        $this->mission = $mission;
    }

    public function startMissionLoop()
    {
        $this->createUniqueMissionHandler();
        for($this->stageIndex = $this->gameSave->stage; $this->stageIndex < sizeof($this->mission->data); $this->stageIndex++) {
            $this->setCurrentStage();
            $this->printText();
            $this->mapOptionsToDecisions();

            while (!$this->hasProgressed()) {
                $this->displayOptions();
                $this->handleDecision();
            }

            $this->uniqueHandler->toggleProgress();
            $this->updateGameState();
        }
    }

    private function updateGameState(): void
    {
        $this->gameState->stage = $this->stageIndex;
    }
}