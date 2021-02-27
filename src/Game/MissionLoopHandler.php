<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GameData\Missions\BaseDecisionHandler;
use Hyperdrive\Traits\MusicHandler;
use Hyperdrive\Traits\SaveHandler;
use Hyperdrive\Traits\TextHandler;

trait MissionLoopHandler
{
    use TextHandler;
    use SaveHandler;
    use MusicHandler;

    private int $lineIndex = 1;
    private int $stageIndex = 0;
    private array $currentStage;
    private BaseDecisionHandler $uniqueHandler;

    private function createUniqueMissionHandler(): void
    {
        $this->uniqueHandler = $this->mission->getDecisionHandler();
        $this->uniqueHandler->setGameState($this->gameState);
    }

    private function printText(): void
    {
        $stage = $this->currentStage;
        $condition = $stage[0]["linesCount"];

        for ($this->lineIndex = 1; $this->lineIndex <= $condition; $this->lineIndex++) {
            $this->playMusic($this->gameState->missionId, $this->stageIndex + 1);
            $this->typewriterEffect($stage[$this->lineIndex]);
        }
    }

    private function mapOptionsToDecisions(): void
    {
        $this->uniqueHandler->clearOptions();
        $stage = $this->currentStage;
        $options = $stage[$this->lineIndex]["options"];
        $decisions = $stage[$this->lineIndex + 1]["decisions"];

        for ($i = 0; $i < sizeof($options); $i++) {
            $decision = $decisions[$i];
            $option = $options[$i];
            $this->uniqueHandler->addOptions($decision, $option);
        }
    }

    private function displayOptions(): void
    {
        $this->uniqueHandler->displayMenu();
    }

    private function setCurrentStage(): void
    {
        $this->currentStage = $this->mission->data[$this->stageIndex];
    }

    private function handleDecision(): void
    {
        $decision = $this->uniqueHandler->getResult();
        $this->uniqueHandler->handleDecision($decision);
    }

    private function hasProgressed(): bool
    {
        return $this->uniqueHandler->isProgressing();
    }

    private function saveGame(): void
    {
        $saveData = (array)$this->gameState;

        $sortedData = $this->sortForGameSave($saveData);

        $this->serialize($sortedData);
        $this->typewriterEffect("Game saved successfully!");
    }

    private function startLoop(): void
    {
        for ($this->stageIndex = $this->gameSave->stage; $this->stageIndex < sizeof($this->mission->data); $this->stageIndex++) {
            $this->setCurrentStage();
            $this->printText();
            $this->mapOptionsToDecisions();

            while (!$this->hasProgressed()) {
                $this->displayOptions();
                $this->handleDecision();

                if ($this->uniqueHandler->isSaveFlagSet()) {
                    $this->saveGame();
                }
            }

            $this->uniqueHandler->toggleProgress();
            $this->updateGameState();
        }
    }

    private function endMission(): void
    {
        $this->gameState->missionId = $_SESSION['nextMission'];
        $this->gameState->stage = 0;
        $this->saveGame();
    }

    private function updateGameState(): void
    {
        $this->gameState->stage = $this->stageIndex + 1;
    }
}