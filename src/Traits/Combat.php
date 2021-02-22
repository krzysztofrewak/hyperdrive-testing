<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

use Hyperdrive\Being;
use Hyperdrive\Enemy;
use Hyperdrive\Friendly;
use Illuminate\Support\Collection;

/**
 * @package Hyperdrive\GameModules
 * @var Being[] $friendlyTeam
 * @var Being[] $enemyTeam
 */
trait Combat
{
    private int $enemyStrengthLevel = 0;
    private bool $isPlayerAttacking;
    private int $coverBonus;
    private Collection $friendlyTeam;
    private Collection $enemyTeam;

    public function setUpCombatEnvironment(int $coverHeight): void
    {
        if ($coverHeight <= 1) {
            $this->coverBonus = 12;
        }

        if ($coverHeight === 2) {
            $this->coverBonus = 25;
        }

        if ($coverHeight >= 3) {
            $this->coverBonus = 33;
        }

        $this->friendlyTeam = collect();
        $this->enemyTeam = collect();
    }

    public function startCombat(bool $isPlayerAttacking = true): void
    {
        $this->isPlayerAttacking = $isPlayerAttacking;

        if ($isPlayerAttacking) {
            $this->typewriterEffect("You start");
        } else {
            $this->typewriterEffect("Enemy starts");
        }

        print_r($this->friendlyTeam->all());
        print_r($this->enemyTeam->all());
        $this->playTurn();
    }

    private function playTurn(): void
    {

        // shuffle who gets action
        $this->EndTurn();
    }

    private function EndTurn(): void
    {
        $this->isPlayerAttacking = !$this->isPlayerAttacking;
    }

    private function setUpFriendlyTeam(array $main, array $friend1, array $friend2): void
    {
        $team = func_get_args();
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
        $player = $this->friendlyTeam->get(0);
        $player->setPlayerBeing();
        $bonus = $player->getBonus();
        $specialization = $player->getSpecialization();
        $this->applyBonus($this->friendlyTeam, $bonus, $specialization);
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
}
