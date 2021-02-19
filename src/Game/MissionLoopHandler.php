<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GameData\Missions\DecisionHandlerInterface;
use League\CLImate\CLImate;

trait MissionLoopHandler
{
    private int $index = 1;
    private array $currentStage;
    private int $stageIndex = 0;
    private DecisionHandlerInterface $uniqueHandler;
    // decide where to keep it
    public CLImate $cli;

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

    public function typewriterEffect(string $sentence = ""): void
    {
        foreach (str_split($sentence) as $letter) {
            $this->cli->inline($letter);
            usleep(5);
        }
        //sleep(1);
        echo PHP_EOL;
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

    public function setCurrentStage(): void
    {
        $this->currentStage = $this->mission->data[$this->stageIndex];
    }

    public function getCurrentStage()
    {
        return $this->currentStage;
    }

    public function handleDecision(): void
    {
        $decision = $this->uniqueHandler->getResult();
        $this->uniqueHandler->handleDecision($decision);

        if ($this->uniqueHandler->isSaveFlagSet())
        {
            $this->saveGame();
        }
    }

    private function hasProgressed(): bool
    {
        return $this->uniqueHandler->isProgressing();
    }

    private function saveGame(): void
    {
        $saveData = (array)$this->gameState;
        echo "save#@Q#";
        print_r($saveData);
        $sortedData = [
          "player" => $saveData["player"],
          "friend1" => $saveData["friend1"],
          "friend2" => $saveData["friend2"],
          "money" => $saveData["money"],
          "fuel" => $saveData["fuel"],
          "team" => $saveData["team"],
          "currentPlanet" => $saveData["currentPlanet"],
          "targetPlanet" => $saveData["targetPlanet"],
          "missionId" => $saveData["missionId"],
          "stage" => $saveData["stage"]
        ];
        print_r($sortedData);

        $saveFile = fopen($_SESSION['saveFile'], 'w');

        foreach ($sortedData as $record)
        {
            if(is_array($record))
            {
                foreach ($record as $index) {
                    fwrite($saveFile, "$index;");
                }
                fwrite($saveFile, "\n");
            } else {
                fwrite($saveFile, "$record;\n");
            }
        }

        fclose($saveFile);
        unset($saveData);
        echo "Succ saved" . PHP_EOL;
    }
}