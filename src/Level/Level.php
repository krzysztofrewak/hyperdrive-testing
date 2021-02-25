<?php

declare(strict_types=1);

namespace Hyperdrive\Level;

use JetBrains\PhpStorm\ArrayShape;

class Level
{
    protected string $name;
    protected int $fuel;
    protected int $capital;
    protected int $hyperspaceJumpsLimit = 10;
    protected bool $unlockedMap = false;

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

    public function isUnlockedMap(): bool
    {
        return $this->unlockedMap;
    }

    #[ArrayShape([
        "Difficulty Level" => "string",
        "Fuel" => "int",
        "Capital" => "int",
        "Hyperspace jumps limit" => "int",
        "Unlocked Map" => "string",
    ])]
    public function getLevelData(): array
    {
        return [
            "Difficulty Level" => $this->name,
            "Fuel" => $this->fuel,
            "Capital" => $this->capital,
            "Hyperspace jumps limit" => $this->hyperspaceJumpsLimit,
            "Unlocked Map" => $this->unlockedMap ? "true" : "false",
        ];
    }

    private function setLevelData(array $levelData): void
    {
        $this->name = $levelData["name"];
        $this->fuel = $levelData["fuel"];
        $this->capital = $levelData["capital"];

        if (array_key_exists("hyperspace-jumps-limit", $levelData)) {
            $this->hyperspaceJumpsLimit = $levelData["hyperspace-jumps-limit"];
        }

        if (array_key_exists("unlocked-map", $levelData)) {
            $this->unlockedMap = $levelData["unlocked-map"];
        }
    }
}
