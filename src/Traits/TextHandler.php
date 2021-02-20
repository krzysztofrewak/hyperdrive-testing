<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

use League\CLImate\CLImate;

trait TextHandler
{
    private CLImate $cli;

    public function init(): void
    {
        $this->cli = new CLImate();
    }

    public function typewriterEffect(string $sentence = ""): void
    {
        $cli = new CLImate();
        foreach (str_split($sentence) as $letter) {
            $cli->inline($letter);
            usleep(5);
        }
        // sleep(1);
        echo PHP_EOL;
    }
}