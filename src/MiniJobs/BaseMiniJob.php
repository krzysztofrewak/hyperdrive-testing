<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs;

use Illuminate\Support\Collection;

abstract class BaseMiniJob implements MiniJobsInterface
{
    protected int $playerMoney;
    protected string $playerName;
    protected Collection $players;

    public function __construct(string $playerName, int $money)
    {
        $this->playerName = $playerName;
        $this->playerMoney = $money;
        $this->prepareEnvironment();
        $this->setupActors();
        $this->play();
    }

    public function getPlayerEarnings(): int
    {
        return $this->players->get(0)->getPlayerMoney();
    }
}