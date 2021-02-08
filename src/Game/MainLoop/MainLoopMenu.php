<?php


namespace Hyperdrive\Game\MainLoop;


use Hyperdrive\Menu;

class MainLoopMenu extends Menu
{
    public function __construct()
    {
        parent::__construct();
        $this->options = [
            "something" => "Do something",
            "return" => "Return to main menu",
            "quit" => "Quit application"
        ];
        $this->displayMenu();
        $this->handleMenu();
    }

    public function handleMenu(): void
    {
        while(True)
        {
            if ($this->choice === "quit")
            {
                exit();
            }

            if ($this->choice === "return")
            {
                break;
            }

            if ($this->choice === "something")
            {
                echo "You did something" . PHP_EOL;
            }

            $this->displayMenu();

            continue;
        }
    }
}