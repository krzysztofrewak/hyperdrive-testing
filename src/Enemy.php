<?php

declare(strict_types=1);

namespace Hyperdrive;

class Enemy extends Being
{
    public function setEnemyStrength(int $strengthLevel): void
    {
        $this->weaponType = $this->getWeaponType($strengthLevel);
        $this->weaponStrength += $this->getWeaponStrength() + $strengthLevel;

        $this->setTag("Enemy");
    }
}