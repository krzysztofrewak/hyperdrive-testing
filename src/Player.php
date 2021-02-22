<?php

declare(strict_types=1);

namespace Hyperdrive;

class Player extends Friendly
{
    public function getBonus(): int
    {
        return $this->bonus;
    }

    public function setBonus(): void
    {
        if ($this->specialization === "Commander") {
            // Defence
            $this->bonus = 10;
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

    public function shoot(Being $being): void
    {
        echo "HEHEHEHE";
    }
}