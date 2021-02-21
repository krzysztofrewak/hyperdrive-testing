<?php

declare(strict_types=1);

namespace Hyperdrive\Level;

use JetBrains\PhpStorm\ArrayShape;

class Level
{
    protected int $fuel;
    protected int $capital;
    protected string $name;

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

    #[ArrayShape([
        "name" => "string",
        "capital" => "int",
        "fuel" => "int",
    ])]
    public function getLevelData(): array
    {
        return [
            "name" => $this->name,
            "capital" => $this->capital,
            "fuel" => $this->fuel,
        ];
    }

    private function setLevelData(array $levelData): void
    {
        $this->name = $levelData["name"];
        $this->fuel = $levelData["fuel"];
        $this->capital = $levelData["capital"];
    }
}
