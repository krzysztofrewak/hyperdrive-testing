<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GameData\Missions\DecisionHandlerInterface;
use Hyperdrive\Traits\SaveHandler;
use Hyperdrive\Traits\TextHandler;

trait MissionLoopHandler
{
    use TextHandler;
    use SaveHandler;

    private int $index = 1;
    private int $stageIndex = 0;
    private array $currentStage;
    private DecisionHandlerInterface $uniqueHandler;

    public function createUniqueMissionHandler(): void
    {
        $this->uniqueHandler = $this->mission->getDecisionHandler();
    }

    public function printText(): void
    {
        $stage = $this->currentStage;
        $condition = $stage[0]["linesCount"];

        for ($this->index = 1; $this->index <= $condition; $this->index++) {
            $this->typewriterEffect($stage[$this->index]);
        }
    }

    public function mapOptionsToDecisions(): void
    {
        $this->uniqueHandler->clearOptions();
        $stage = $this->currentStage;
        $options = $stage[$this->index]["options"];
        $decisions = $stage[$this->index + 1]["decisions"];

        for ($i = 0; $i < sizeof($options); $i++) {
            $decision = $decisions[$i];
            $option = $options[$i];
            $this->uniqueHandler->addOptions($decision, $option);
        }
    }

    public function displayOptions(): void
    {
        $this->uniqueHandler->displayMenu();
    }

    public function setCurrentStage(): void
    {
        $this->currentStage = $this->mission->data[$this->stageIndex];
    }

    public function handleDecision(): void
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
}