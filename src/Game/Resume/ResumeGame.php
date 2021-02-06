<?php

declare(strict_types=1);

namespace Hyperdrive\Game\Resume;

use Hyperdrive\BaseGameType;
use Hyperdrive\GameSave;

class ResumeGame extends BaseGameType
{

    public function __construct()
    {
        $this->gameSave = new GameSave();
        $gameSaveData = $this->getGameStateFromSaveFile();
        $this->gameSave->fillFromSaveFile($gameSaveData);
    }

    private function getGameStateFromSaveFile(): array
    {
        $data = array_map('str_getcsv', file($_SESSION['saveFile']));
        foreach ($data as &$record)
        {
            $record = implode("", $record);
            $record = explode(";", $record, -1);
        }
        return $data;
    }
}