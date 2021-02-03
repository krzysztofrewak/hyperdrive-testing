<?php

declare(strict_types=1);

namespace Hyperdrive\GameInitialization;

use Hyperdrive\Menu;
use Hyperdrive\Traits\MainMenuHandler;

class MainMenu extends Menu
{
    use MainMenuHandler;

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

    public function getResult(): string
    {
        return $this->choice;
    }
}