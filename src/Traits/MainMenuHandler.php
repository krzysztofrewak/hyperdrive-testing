<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

trait MainMenuHandler
{
    use MainMenuMethods;

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
            }

            if($this->choice === "resume")
            {
                $this->resume();
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