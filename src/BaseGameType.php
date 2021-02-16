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
}