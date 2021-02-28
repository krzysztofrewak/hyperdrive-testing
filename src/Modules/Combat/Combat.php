<?php

declare(strict_types=1);

namespace Hyperdrive\Modules\Combat;

use Hyperdrive\Handlers\TextHandler;
use Illuminate\Support\Collection;

trait Combat
{
    use TextHandler;

    private int $enemyStrengthLevel = 0;
    private bool $isPlayerAttacking;
    private int $coverBonus;
    private bool $hasPlayerWon;
    private string $lastTeamTag = "";
    private Team $friendlyTeam;
    private Team $enemyTeam;
    private Collection $turnOrder;
    private Collection $playedTurn;

    public function setUpCombatEnvironment(int $coverHeight): void
    {
        if ($coverHeight <= 1) {
            $this->coverBonus = 2;
        }

        if ($coverHeight === 2) {
            $this->coverBonus = 3;
        }

        if ($coverHeight >= 3) {
            $this->coverBonus = 5;
        }

        $this->friendlyTeam = new Team();
        $this->enemyTeam = new Team();
    }

    public function startCombat(): void
    {
        $this->displayShootoutInfo($this->friendlyTeam->getTeam(), $this->enemyTeam->getTeam());
        $this->begin();
    }

    private function begin(): void
    {
        $this->playedTurn = collect();
        while (!$this->isCombatOver()) {
            $this->simulateTurn();
        }
        $this->endCombat();
    }

    private function simulateTurn(): void
    {
        $t1 = $this->friendlyTeam->getTeam();
        $t2 = $this->enemyTeam->getTeam();
        $turnOrder = $t1->merge($t2)->shuffle();
        $this->assignEnemies();

        while ($turnOrder !== $this->playedTurn) {
            $iterator = $turnOrder->getIterator();
            while (true) {
                $being = $iterator->current();
                if ($this->playedTurn->contains($being)) {
                    $iterator->next();
                } else if (!$iterator->valid()) {
                    $this->playedTurn = collect();
                    break 2;
                } else {
                    break;
                }
            }

            $this->lastTeamTag = $being->getTag();

            if (!$this->playedTurn->contains($being)) {
                if ($this->lastTeamTag === "Enemy") {
                    $this->enemyTeam->startShooting($being);
                } else {
                    $this->friendlyTeam->startShooting($being);
                }
                $this->handleTeams();
                $this->playedTurn->add($being);
                break;
            }
        }
    }

    public function handleTeams(): void
    {
        $this->enemyTeam->removeDead();
        $this->friendlyTeam->removeDead();
    }

    private function setUpFriendlyTeam(array $main, array $friend1, array $friend2): void
    {
        $team = [];
        array_push($team, $friend1, $friend2);
        $this->createPlayerControlledBeing($main);
        $this->createFriends($team);
        $this->applyBonusToFriendlyTeam();
    }

    private function createFriends(array $team): void
    {
        foreach ($team as $being) {
            $specialization = explode(" - ", $being[1])[0];
            $being = new Friendly($being[0], $this->coverBonus);
            $being->setFriendlyStrength($specialization);
            $this->friendlyTeam->add($being);
        }
    }

    private function createPlayerControlledBeing(array $player): void
    {
        $specialization = explode(" - ", $player[1])[0];
        $being = new Player($player[0], $this->coverBonus);
        $being->setFriendlyStrength($specialization);
        $this->friendlyTeam->add($being);
    }

    private function setUpEnemyTeam(int $enemiesCount, int $enemyStrengthLevel): void
    {
        for ($i = 1; $i <= $enemiesCount; $i++) {
            $enemy = new Enemy("Enemy $i", $this->coverBonus);
            $enemy->setEnemyStrength($enemyStrengthLevel);
            $this->enemyTeam->add($enemy);
        }
    }

    private function applyBonusToFriendlyTeam(): void
    {
        $player = $this->friendlyTeam->getCommander();
        $player->setBonus();
        $bonus = $player->getBonus();
        $specialization = $player->getSpecialization();
        $this->applyBonus($this->friendlyTeam->getTeam(), $bonus, $specialization);
    }

    private function applyBonus(Collection $team, int $bonusValue, string $bonusClass): void
    {
        $bonusType = $this->getBonusType($bonusClass);

        foreach ($team as $being) {
            $being->applyBonus($bonusValue, $bonusType);
        }
    }

    private function getBonusType(string $class): string
    {
        if ($class === "Commander") {
            $type = "defence";
        }

        if ($class === "Rifleman") {
            $type = "accuracy";
        }

        if ($class === "Demolition") {
            $type = "strength";
        }

        if ($class === "Engineer") {
            $type = "strength";
        }

        return $type;
    }

    private function isCombatOver(): bool
    {
        return !$this->enemyTeam->isAlive() || !$this->friendlyTeam->isAlive();
    }

    private function assignEnemies(): void
    {
        $this->enemyTeam->removeDead();
        $this->friendlyTeam->removeDead();
        $this->enemyTeam->addEnemyTeam($this->friendlyTeam->getTeam());
        $this->friendlyTeam->addEnemyTeam($this->enemyTeam->getTeam());
    }

    private function endCombat(): void
    {
        if ($this->lastTeamTag === "Enemy") {
            $this->typewriterEffect("You are defeated. Try again.");
            $this->hasPlayerWon = false;
        } else {
            $this->typewriterEffect("You managed to win.");
            $this->hasPlayerWon = true;
        }
    }

    public function hasPlayerWon(): bool
    {
        return $this->hasPlayerWon;
    }
}
