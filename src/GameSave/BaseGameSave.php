<?php

declare(strict_types=1);

namespace Hyperdrive\GameSave;

abstract class BaseGameSave
{
    public array $player;
    public array $friend1;
    public array $friend2;
    public int $money = 30_000;
    public int $fuel = 100;
    public string $team;
    public string $currentPlanet = "triton";
    public ?string $targetPlanet = null;
    public string $missionId = "mission1";
}