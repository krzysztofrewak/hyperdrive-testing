<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GameSave;
use Hyperdrive\GameSave\IntegrityController;

class Game
{
    use IntegrityController;

    public GameSave $gameSave;

    public function __construct(GameSave $gameSave)
    {
        $this->gameSave = $gameSave;
        $this->toggleInGameState();
    }

    public function run(MissionLoop $loop): void
    {
        $loop->start();
    }
}