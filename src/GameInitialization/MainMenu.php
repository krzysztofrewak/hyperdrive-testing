<?php

declare(strict_types=1);

namespace Hyperdrive\GameInitialization;

use Hyperdrive\GameSave\IntegrityController;
use Hyperdrive\Menu;
use Hyperdrive\Handlers\MainMenuHandler;

class MainMenu extends Menu
{
    use MainMenuHandler;
    use IntegrityController;

    public function __construct()
    {
        parent::__construct();
        $this->options = [
            "startNewGame" => "Start new game",
            "resume" => "Resume",
            "achieve" => "Achievements",
            "options" => "Options",
            "quit" => "Quit application"
        ];
        $this->displayMenu();
        $this->handleMenu();
    }

    public function handleMenu(): void
    {
        while (True) {
            if ($this->choice === "quit") {
                break;
            }

            if ($this->choice === "startNewGame") {
                $this->start();
                $this->toggleInGameState();
            }

            if ($this->choice === "resume") {
                $this->resume();
                $this->toggleInGameState();
            }

            if ($this->choice === "achieve") {
                $this->achievements();
            }

            if ($this->choice === "options") {
                $this->options();
            }

            $this->displayMenu();

            continue;
        }
    }
}