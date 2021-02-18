<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

class MissionLoop
{
    use MissionLoopHandler;

    private Mission $mission;

    public function __construct(Mission $mission)
    {
        $this->mission = $mission;
    }
    public function start()
    {
        /*$this->game = $game;
        var_dump($this->game);*/

        $this->createUniqueMissionHandler();

        foreach ($this->mission->data as $stage) {
            $this->setCurrentStage($stage);
            $this->printText();
            $this->mapOptionsToDecisions();

            while (!$this->hasProgressed()) {
                $this->displayOptions();
                $this->handleDecision();
            }

            $this->uniqueHandler->toggleProgress();
        }
    }

}