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
}