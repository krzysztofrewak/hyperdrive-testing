<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Foraging;

use Hyperdrive\MiniJobs\Foraging\Helpers\Forester;
use Illuminate\Support\Collection;

class Forest
{
    use Forester;

    private Collection $area;

    public function __construct()
    {
        $this->area = collect();
    }

    public function populate(): void
    {
        $this->runForester();
        dd($this->area);
        $this->addFauna();
        $this->addFlora();
    }
}