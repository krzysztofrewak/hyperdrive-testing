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

    public function fillFromSaveFile(array $gameState): void
    {

    }

    public function serialize(): void
    {
        $saveFile = fopen('/application/gamesave', 'w');

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