<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GameData\Missions\DecisionHandlerInterface;

trait MissionLoopHandler
{
    private int $index = 1;
    private array $currentStage;
    private string $lineToRepeat;
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
            echo $stage[$this->index] . PHP_EOL;
            $this->lineToRepeat = $stage[$this->index];
        }
    }

    public function mapOptionsToDecisions(): void
    {
        $this->uniqueHandler->clearOptions();
        $stage = $this->currentStage;
        $options = $stage[$this->index]["options"];
        $decisions = $stage[$this->index + 1]["decisions"];

        for ($i=0; $i<sizeof($options);$i++) {
            $decision = $decisions[$i];
            $option = $options[$i];
            $this->uniqueHandler->addOptions($decision, $option);
        }
    }

    public function displayOptions(): void
    {
        $this->uniqueHandler->displayMenu();
    }

    public function setCurrentStage(array $stage): void
    {
        $this->currentStage = $stage;
    }

    public function handleDecision(): void
    {
        $this->printLastLine();
        //                          getDecision()
        $decision = $this->uniqueHandler->getResult();
        $this->uniqueHandler->handleDecision($decision);
    }

    private function printLastLine(): void
    {
        echo $this->lineToRepeat . PHP_EOL;
    }

    private function hasProgressed(): bool
    {
        return $this->uniqueHandler->isProgressing();
    }
}