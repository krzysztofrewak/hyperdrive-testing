<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use League\CLImate\CLImate;
use Symfony\Component\Config\Definition\Exception\Exception;

abstract class BasePanel
{
    protected CLImate $cli;

    protected function __construct()
    {
        $this->cli = new CLImate();
    }

    public function showException(Exception $exception): void
    {
        $this->cli->error($exception->getMessage());
    }
}
