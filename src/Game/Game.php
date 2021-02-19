<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\Game\MainLoop\GameState;
use Hyperdrive\GameSave;
use Hyperdrive\GameSave\IntegrityController;

class Game
{
    use IntegrityController;
    use MissionLoopT;

    public GameSave $gameSave;
    public GameState $gameState;

    public function __construct(GameSave $gameSave)
    {
        $this->gameSave = $gameSave;
        $this->toggleInGameState();
    }

    public function start(Mission $mission): void
    {
        $this->constructMissionLoop($mission);
        $this->startMissionLoop();
        //$loop->start();
    }
}