<?php


namespace Hyperdrive\Game\MainLoop;


class GameState
{
    public array $player = [];
    public array $friend1 = [];
    public array $friend2 = [];
    public string $team = "";
    public int $money = 0;
    public string $currentPlanet = "";
    public int $fuel = 0;
    public string $targetPlanet = "";
    public string $missionId = "";
    public int $stage = 0;
}