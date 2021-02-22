<?php

declare(strict_types=1);

namespace Hyperdrive\Traits;

use Hyperdrive\Being;
use Hyperdrive\Enemy;
use Hyperdrive\Friendly;
use Hyperdrive\Player;
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

    public function startCombat(): void
    {
        print_r($this->friendlyTeam->all());
        print_r($this->enemyTeam->all());
        $this->begin();
    }

    private function begin(): void
    {
        //while ($this->isCombatOver()) {
            $this->simulateTurn();
        //}
        // AI
        // draw not hiding enemy
        // if has bullets in gun
        // then shoot or use special ability
        // else reload
        // PLAYER
        // use polymorph
        // Choose enemy to shoot
        // shoot or use special ability
        // shuffle who gets action
    }

    private function simulateTurn(): void
    {
        $turnOrder = $this->friendlyTeam->merge($this->enemyTeam)->shuffle();

        foreach ($turnOrder as $being) {

            if ($being->getTag() === "Friend") {
                $beingToShoot = $this->enemyTeam->random();
            } else {
                $beingToShoot = $this->friendlyTeam->random();
            }

            $being->shoot($beingToShoot);
        }
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
        $player = $this->friendlyTeam->get(0);
        $player->setBonus();
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

    private function isCombatOver(): bool
    {
        return true;
    }
}
