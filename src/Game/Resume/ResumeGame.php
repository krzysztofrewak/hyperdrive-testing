<?php

declare(strict_types=1);

namespace Hyperdrive\Game\Resume;

use Hyperdrive\GameSave;
use Hyperdrive\Interfaces\GameInterface;

class ResumeGame implements GameInterface
{
    private GameSave $gameSave;

    public function __construct()
    {
        $this->gameSave = new GameSave();
        $gameSaveData = $this->getGameStateFromSaveFile();
        $this->gameSave->fillFromSaveFile($gameSaveData);
        // here should be data from the save loaded
        // and then, this game save data, passed to the game creator
    }

    private function getGameStateFromSaveFile(): array
    {

    }

}