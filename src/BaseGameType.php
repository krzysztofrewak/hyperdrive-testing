<?php

declare(strict_types=1);

namespace Hyperdrive;

abstract class BaseGameType
{
    protected GameSave $gameSave;

    public function getGameSave(): GameSave
    {
        return $this->gameSave;
    }

    public function deserialize(): void
    {
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