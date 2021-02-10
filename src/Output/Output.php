<?php

declare(strict_types=1);

namespace Hyperdrive\Output;

use League\CLImate\CLImate;

class Output implements OutputContract
{
    private CLImate $cli;

    public function write(String $message): void
    {
        $this->cli->out($message);
    }

    public function info(string $message)
    {
        $this->cli->info($message);
    }
}