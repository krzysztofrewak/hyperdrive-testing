<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

use League\CLImate\CLImate;

trait TextHandler
{
    private CLImate $climate;

    public function __construct()
    {
        $this->climate = new CLImate();
        $this->climate->addArt('./src/GameData/Art');
    }

    public function typewriterEffect(string $sentence = ""): void
    {
        $this->climate = new CLImate();
        foreach (str_split($sentence) as $letter) {
            $this->climate->inline($letter);
            usleep(5);
        }
        // sleep(1);
        echo PHP_EOL;
    }

    public function drawBanner(string $id): void
    {
        $this->climate->animation($id)->enterFrom('bottom');
        sleep(3);
    }
}