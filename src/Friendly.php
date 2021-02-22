<?php

declare(strict_types=1);

namespace Hyperdrive;

class Friendly extends Being
{
    public function setFriendlyStrength(string $specialization): void
    {
        $this->weaponType = $this->getWeaponType(2);
        $this->weaponStrength += $this->getWeaponStrength() + 2;

        $this->setSpecialization($specialization);
        $this->setTag("Friend");
    }

    public function setPlayerBeing(): void
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
}