<?php

declare(strict_types=1);

namespace Hyperdrive\Level;

use Illuminate\Support\Collection;

/**
 * Class LevelsCollection
 * @package Hyperdrive\Level
 * @var Level[] $levels
 */
class LevelsCollection
{
    protected Collection $levels;

    public function __construct()
    {
        $this->levels = collect();
    }

    public function addLevel(Level $level): void
    {
        $this->levels->add($level);
    }

    public function toArray(): array
    {
        return $this->levels->toArray();
    }

    public function getLevelsData(): array
    {
        $levelsData = [];

        /** @var Level $level */
        foreach ($this->levels as $level) {
            $levelsData[] = $level->getLevelData();
        }

        return $levelsData;
    }
}
