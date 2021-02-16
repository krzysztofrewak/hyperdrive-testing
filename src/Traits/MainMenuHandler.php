<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

use Hyperdrive\GameSave\IntegrityController;

trait MainMenuHandler
{
    use MainMenuMethods, IntegrityController;

    public function handleMenu(): void
    {
        while(True)
        {
            if ($this->choice === "quit")
            {
                break;
            }

            if($this->choice === "startNewGame")
            {
                $this->start();
                $this->toggleInGameState();
            }

            if($this->choice === "resume")
            {
                $this->resume();
                $this->toggleInGameState();
            }

            if($this->choice === "achieve")
            {
                $this->achievements();
            }

            if($this->choice === "options")
            {
                $this->options();
            }

            $this->displayMenu();

            continue;
        }
    }
}