<?php

declare(strict_types=1);

namespace Hyperdrive\Game\MainLoop;

use Hyperdrive\Game\Game;
use Hyperdrive\GameSave\IntegrityController;

class GameLoop extends BaseGameLoop
{
    use IntegrityController;

    private Game $game;

    public function __construct(Game $game)
    {
        parent::__construct($game);
        $this->game = $game;
        if($this->canStartGame())
        {
            $this->buildAssets();
            $this->loadMission();
            $this->startGame();
        }
    }
}