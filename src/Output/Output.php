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

    public function write(String $message): void
    {
        $this->cli->out($message);
    }

    public function info(string $message)
    {
        $this->cli->info($message);
    }

    public function input(string $message): int
    {
        return $this->cli->input($message)->prompt();
    }

    /**
     * @return CLImate
     */
    public function getCli(): CLImate
    {
        return $this->cli;
    }



//    public function radio(string $message, array $options ): string
//    {
//        return $this->cli->radio($message, $options)->prompt();
//    }
}
