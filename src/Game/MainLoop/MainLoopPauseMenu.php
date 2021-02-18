<?php

declare(strict_types=1);

namespace Hyperdrive\Game\MainLoop;

use Hyperdrive\Menu;

class MainLoopPauseMenu extends Menu
{
    public function __construct()
    {
        parent::__construct();
        $this->options = [
            "save" => "Save game",
            "return" => "Return to the game",
            "quit" => "Quit application"
        ];
    }

    public function handleMenu(): void
    {
        while(true)
        {
            if ($this->choice === "quit")
            {
                exit();
            }

            if ($this->choice === "return")
            {
                break;
            }

            if ($this->choice === "save")
            {
                echo "Game is saved!" . PHP_EOL;
            }

            $this->displayMenu();

            continue;
        }
    }
}
