<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\Interfaces\MenuInterface;
use League\CLImate\CLImate;

abstract class Menu implements MenuInterface
{
    public CLImate $cli;
    public array $options;
    public string $choice;

    public function __construct()
    {
        $this->cli = new CLImate();
        $this->cli->addArt('./src/GameData/Art');
    }

    public function displayMenu(string $sentence = "Select option"): void
    {
        $this->choice = $this->cli->radio($sentence, $this->options)->prompt();
    }

    public function getResult(): string
    {
        return $this->choice;
    }
}