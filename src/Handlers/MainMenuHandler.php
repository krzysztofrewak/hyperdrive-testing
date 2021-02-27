<?php

declare(strict_types=1);

namespace Hyperdrive\Handlers;

use Hyperdrive\Game\Game;
use Hyperdrive\Game\MainLoop\GameLoop;
use Hyperdrive\Game\NewGame\NewGame;
use Hyperdrive\Game\Resume\ResumeGame;

trait MainMenuHandler
{
    use TextHandler;

    public function start(): void
    {
        $this->typewriterEffect("Starting new game.");
        new NewGame();
        $this->resume();
    }

    public function resume(): void
    {
        if ($this->ifSaveExists()) {
            $this->typewriterEffect("Resuming game.");
            $gameState = new ResumeGame();
            $game = new Game($gameState);
            new GameLoop($game);
        } else {
            $this->typewriterEffect("Couldn't locate save file.");
        }
    }

    public function achievements(): void
    {
        $this->typewriterEffect("Displaying achievements.");
    }

    public function options(): void
    {
        $this->typewriterEffect("Displaying options.");
    }

    private function ifSaveExists(): bool
    {
        $dir = scandir('/application');
        return (bool)array_search("gamesave", $dir);
    }
}