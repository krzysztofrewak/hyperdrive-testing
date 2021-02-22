<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

use Hyperdrive\Game\Game;
use Hyperdrive\Game\MainLoop\GameLoop;
use Hyperdrive\Game\NewGame\NewGame;
use Hyperdrive\Game\Resume\ResumeGame;

trait MainMenuMethods
{
    public function start(): void
    {
        echo "Starting new game" . PHP_EOL;
        new NewGame();
        $this->resume();
    }

    public function resume(): void
    {
        echo "Resuming game" . PHP_EOL;
        $gameState = new ResumeGame();
        $game = new Game($gameState);
        new GameLoop($game);
    }

    public function achievements(): void
    {
        echo "Displaying achievements" . PHP_EOL;
    }

    public function options(): void
    {
        echo "Displaying options" . PHP_EOL;
    }
}