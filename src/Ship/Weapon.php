<?php


namespace Hyperdrive\Ship;


class Weapon
{
    protected int $dmg;
    protected string $name;

    public function __construct(int $dmg, string $name)
    {
        $this->dmg = $dmg;
        $this->name = $name;
    }

    public function show(): string
    {
        return $this->name." Dmg: ".$this->dmg;
    }

    public function getDmg(): int
    {
        return $this->dmg;
    }

    public function setDmg(int $dmg): void
    {
        $this->dmg = $dmg;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }



}