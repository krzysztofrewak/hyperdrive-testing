<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Foraging;

use Hyperdrive\MiniJobs\BaseMiniJob;
use Hyperdrive\Traits\TextHandler;

class Foraging extends BaseMiniJob
{
    use TextHandler;

    private Forest $forest;

    protected function prepareEnvironment(): void
    {
        $this->forest = new Forest();
    }

    protected function setupActors(): void
    {
        $this->forest->populate();
    }

    protected function play(): void
    {
        $this->forest->find("berries");
        $this->sell();
    }
}