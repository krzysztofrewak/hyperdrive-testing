<?php

declare(strict_types=1);

namespace Hyperdrive\GameSave;

abstract class BaseGameSave
{
    public ?array $player = null;
    public ?array $friend1 = null;
    public ?array $friend2 = null;
    public int $money = 30_000;
    public int $fuel = 100;
    public ?string $team = null;
    public string $currentPlanet = "triton";
    public ?string $targetPlanet = null;
    public string $missionId = "mission1";
}