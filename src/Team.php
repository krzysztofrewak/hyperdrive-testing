<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\Handlers\TextHandler;
use Illuminate\Support\Collection;

class Team
{
    use TextHandler;

    private Collection $friendlyTeam;
    protected Collection $enemyTeam;

    public function __construct()
    {
        $this->friendlyTeam = collect();
        $this->enemyTeam = collect();
    }

    public function add(Being $being): void
    {
        $this->friendlyTeam->add($being);
    }

    public function addEnemyTeam(Collection $enemies): void
    {
        $this->enemyTeam = collect();
        foreach ($enemies as $enemy) {
            if ($enemy->isAlive()) {
                $this->enemyTeam->add($enemy);
            }
        }
    }

    public function getTeam(): Collection
    {
        $this->removeDead();
        return $this->friendlyTeam;
    }

    public function getCommander(): Being
    {
        return $this->friendlyTeam->get(0);
    }

    public function removeDead(): void
    {
        $aliveMembers = collect();
        foreach ($this->friendlyTeam as $being) {
            if ($being->isAlive()) {
                $aliveMembers->add($being);
            }
        }
        $this->friendlyTeam = $aliveMembers;

    }

    public function isAlive(): bool
    {
        return !$this->friendlyTeam->isEmpty();
    }

    public function startShooting(Being $friend): void
    {
        if ($this->enemyTeam->isNotEmpty()) {
            if (explode("\\", get_class($friend))[1] === "Player") {
                $enemy = $friend->chooseEnemy($this->enemyTeam);
            } else {
                $enemy = $this->enemyTeam->random();
                $this->typewriterEffect("$friend->name decided to shoot $enemy->name");
            }
            $friend->shoot($enemy);

            if (!$enemy->isAlive()) {
                $this->typewriterEffect("$enemy->name fells unconscious");
                $enemyId = $this->enemyTeam->search($enemy);
                $this->enemyTeam->forget($enemyId);
            }
        }
    }
}