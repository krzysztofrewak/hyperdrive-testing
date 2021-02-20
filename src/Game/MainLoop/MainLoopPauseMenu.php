<?php

declare(strict_types=1);

namespace Hyperdrive\Game\MainLoop;

use Hyperdrive\Menu;

class MainLoopPauseMenu extends Menu
{
    private bool $saveFlag = false;

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
        $this->saveFlag = false;

        while (true) {
            if ($this->choice === "quit") {
                exit();
            }

            if ($this->choice === "return") {
                break;
            }

            if ($this->choice === "save") {
                $this->toggleGameSaveFlag();
                break;
            }

            $this->displayMenu();

            continue;
        }
    }

    private function toggleGameSaveFlag()
    {
        $this->saveFlag = !$this->saveFlag;
    }

    public function getSaveFlagState(): bool
    {
        return $this->saveFlag;
    }
}
