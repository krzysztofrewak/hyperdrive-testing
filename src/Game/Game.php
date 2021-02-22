<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\BaseGameType;
use Hyperdrive\Game\MainLoop\GameState;
use Hyperdrive\GameSave;
use Hyperdrive\GameSave\IntegrityController;

class Game
{
    use IntegrityController;
    use MissionLoopManager;

    public GameSave $gameSave;
    public GameState $gameState;
    public BaseGameType $gameType;

    public function __construct(BaseGameType $gameType)
    {
        $this->gameType = $gameType;
        $this->gameSave = $gameType->getGameSave();
    }

    public function play(Mission $mission): void
    {
        $this->constructMissionLoop($mission);
        $this->startMissionLoop();
    }
}