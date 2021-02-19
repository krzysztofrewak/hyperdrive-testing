<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\GameSave\BaseGameSave;

class GameSave extends BaseGameSave
{
    public function fillNewSave(array $userProvidedData): void
    {
        $this->player = [$userProvidedData[0][0], $userProvidedData[0][1]];
        $this->team = $userProvidedData[0][2];
        $this->friend1 = $userProvidedData[1];
        $this->friend2 = $userProvidedData[2];
        $this->serialize();
    }

    public function fillFromSaveFile(array $gameSaveData): void
    {
        $this->player = $gameSaveData[0];
        $this->friend1 = $gameSaveData[1];
        $this->friend2 = $gameSaveData[2];
        $this->money = (int) $gameSaveData[3][0];
        $this->fuel = (int) $gameSaveData[4][0];
        $this->team = $gameSaveData[5][0];
        $this->currentPlanet = $gameSaveData[6][0];
        $this->targetPlanet = $gameSaveData[7][0];
        $this->missionId = $gameSaveData[8][0];
        $this->stage = (int) $gameSaveData[9][0];
    }

    public function serialize(): void
    {
        $saveFile = fopen($_SESSION['saveFile'], 'w');

        foreach ($this as $record)
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
    }
}