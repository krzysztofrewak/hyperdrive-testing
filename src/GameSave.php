<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\GameSave\BaseGameSave;
use Hyperdrive\Traits\SaveHandler;

class GameSave extends BaseGameSave
{
    use SaveHandler;

    public function fillNewSave(array $userProvidedData): void
    {
        $this->player = [$userProvidedData[0][0], $userProvidedData[0][1]];
        $this->friend1 = $userProvidedData[1];
        $this->friend2 = $userProvidedData[2];
        $this->money = 30000;
        $this->fuel = 100;
        $this->team = $userProvidedData[0][2];
        $this->timeSpent = 0;
        $this->currentPlanet = "Vanik";
        $this->targetPlanet = "";
        $this->missionId = "intro";
        $this->stage = 0;
        $this->serialize((array)$this);
    }

    public function fillFromSaveFile(array $gameSaveData): void
    {
        $this->player = $gameSaveData[0];
        $this->friend1 = $gameSaveData[1];
        $this->friend2 = $gameSaveData[2];
        $this->money = (int)$gameSaveData[3][0];
        $this->fuel = (int)$gameSaveData[4][0];
        $this->team = $gameSaveData[5][0];
        $this->timeSpent = (int)$gameSaveData[6][0];
        $this->currentPlanet = $gameSaveData[7][0];
        $this->targetPlanet = $gameSaveData[8][0];
        $this->missionId = $gameSaveData[9][0];
        $this->stage = (int)$gameSaveData[10][0];
    }
}