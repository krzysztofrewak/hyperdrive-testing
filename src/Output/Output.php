<?php

declare(strict_types=1);

namespace Hyperdrive\Output;

use League\CLImate\CLImate;

class Output implements OutputContract
{
    protected CLImate $cli;

    public function __construct(CLImate $cli)
    {
        $this->cli = $cli;
    }

    public function write(string $message): void
    {
        $this->cli->out($message);
    }

    public function info(string $message)
    {
        $this->cli->info($message);
    }

    public function input(string $message, int $limit): string
    {

        while (true) {
            $scan = $this->cli->input($message)->prompt();

            if ($scan >= 1 && $scan <= $limit) {
                return $scan;
            } else {
                $this->write("Something went wrong, please enter a number that is greater than or equal to 1 and equal or less than or equal to $limit");
            }
        }
    }

    public function getCli(): CLImate
    {
        return $this->cli;
    }

}
