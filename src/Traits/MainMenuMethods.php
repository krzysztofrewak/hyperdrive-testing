<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

trait MainMenuMethods
{
    public function start(): void
    {
        echo "Starting new game" . PHP_EOL;
    }

    public function resume(): void
    {
        echo "Resuming game" . PHP_EOL;
    }

    public function achievements(): void
    {
        echo "Displaying achievements" . PHP_EOL;
    }

    public function options(): void
    {
        echo "Displaying options" . PHP_EOL;
    }

}