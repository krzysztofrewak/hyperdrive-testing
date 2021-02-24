<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\Traits\TextHandler;
use Illuminate\Support\Collection;

class Player extends Friendly
{
    use TextHandler;

    public function getBonus(): int
    {
        return $this->bonus;
    }

    public function setBonus(): void
    {
        if ($this->specialization === "Commander") {
            // Defence
            $this->bonus = 5;
            $this->weaponType = 1;
        }

        if ($this->specialization === "Rifleman") {
            // Accuracy
            $this->bonus = 10;
            $this->weaponType = 2;
        }

        if ($this->specialization === "Demolition") {
            // Weapon strength
            $this->bonus = 6;
        }

        if ($this->specialization === "Engineer") {
            // Weapon strength
            $this->bonus = 3;
        }
    }

    public function chooseEnemy(Collection $enemies): Enemy
    {
        $decisions = [];
        $this->typewriterEffect("Choose who gets shot");
        for ($i = 0; $i < sizeof($enemies); $i++) {
            echo $i . ". ";
            $enemy = $enemies->get($i);
            $this->typewriterEffect($enemy->name ." health: $enemy->health");
            array_push($decisions, $i);
        }

        $enemyId = $this->getInput($decisions, "enemy");

        return $enemies->get($enemyId);
    }
}