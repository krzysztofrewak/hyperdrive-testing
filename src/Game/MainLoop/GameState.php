<?php


namespace Hyperdrive\Game\MainLoop;


class GameState
{
    public array $player = [];
    public array $friend1 = [];
    public array $friend2 = [];
    public int $money = 0;
    public int $fuel = 0;
    public string $team = "";
    public string $currentPlanet = "";
    public string $targetPlanet = "";
    public string $missionId = "";
    public int $stage = 0;
}