<?php

declare(strict_types=1);

namespace Hyperdrive\GameSave;

abstract class BaseGameSave
{
    public array $player;
    public array $friend1;
    public array $friend2;
    public int $money;
    public int $fuel;
    public string $team;
    public int $timeSpent;
    public string $currentPlanet;
    public string $targetPlanet;
    public string $missionId;
    public int $stage;
}