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

    /**
     * @return int
     */
    public function getDmg(): int
    {
        return $this->dmg;
    }

    /**
     * @param int $dmg
     */
    public function setDmg(int $dmg): void
    {
        $this->dmg = $dmg;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}