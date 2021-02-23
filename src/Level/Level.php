<?php

declare(strict_types=1);

namespace Hyperdrive\Level;

use JetBrains\PhpStorm\Pure;

class Level
{
    protected string $name;
    protected int $fuel;
    protected int $capital;
    protected int $hyperspaceJumpsLimit = 10;

    public function __construct(array $levelData)
    {
        $this->setLevelData($levelData);
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getFuel(): int
    {
        return $this->fuel;
    }

    public function getCapital(): int
    {
        return $this->capital;
    }

    public function getHyperspaceJumpsLimit(): int
    {
        return $this->hyperspaceJumpsLimit;
    }

    #[Pure]
    public function getLevelData(): array
    {
        return get_object_vars($this);
    }

    private function setLevelData(array $levelData): void
    {
        $this->name = $levelData["name"];
        $this->fuel = $levelData["fuel"];
        $this->capital = $levelData["capital"];

        if (array_key_exists("hyperspace-jumps-limit", $levelData)) {
            $this->hyperspaceJumpsLimit = $levelData["hyperspace-jumps-limit"];
        }
    }
}
