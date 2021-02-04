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
    }

    public function fillFromSaveFile(array $gameState): void
    {

    }
}