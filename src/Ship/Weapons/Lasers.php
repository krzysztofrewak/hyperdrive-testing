<?php

declare(strict_types=1);

namespace Hyperdrive\Ship\Weapons;

use Hyperdrive\Ship\Weapon;

class Lasers extends Weapon
{
    protected int $dmg;
    protected string $name;

    public function __construct(int $dmg, string $name) {
        $this->dmg = $dmg;
        $this->name = $name;
    }
}