<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Foraging;

use Hyperdrive\MiniJobs\Foraging\Helpers\Forester;
use Hyperdrive\Handlers\TextHandler;
use Illuminate\Support\Collection;

class Forest
{
    use Forester;
    use TextHandler;

    private Collection $area;

    public function __construct()
    {
        $this->area = collect();
    }

    public function populate(): void
    {
        $this->runForester();
        $this->addFlora();
        $this->addFauna();
    }

    public function find(string $foodType): int
    {
        $seeked = 0;
        $this->loadingEffect("Looking for $foodType", 1);
        $forestSize = sizeof($this->area);
        $forest = $this->area->shuffle();
        $startingPoint = rand(0, $forestSize);
        for ($i = $startingPoint; $i < $forestSize; $i++) {
            $found = $forest->get($i);
            if ($found === "berries") {
                $seeked += 1;
            }
        }
        $this->typewriterEffect("Found $seeked ounces of $foodType");
        return $seeked;
    }
}