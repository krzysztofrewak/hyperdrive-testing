<?php


namespace Hyperdrive\Entity\Players;


class Player
{
    private int $power = 0;
    private int $armor = 0;
    private string $name = "";
    private int $exp = 0;

    public function __construct(int $power, int $armor, string $name, int $exp)
    {
        $this->power = $power;
        $this->armor = $armor;
        $this->name = $name;
        $this->exp = $exp;
    }

    public function __toString(): string
    {
        return $this->name;
    }


    public function getPower(): int
    {
        return $this->power;
    }

    public function setPower(int $power): void
    {
        $this->power = $power;
    }

    public function getArmor(): int
    {
        return $this->armor;
    }

    public function setArmor(int $armor): void
    {
        $this->armor = $armor;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getExp(): int
    {
        return $this->exp;
    }

    public function setExp(int $exp): void
    {
        $this->exp = $exp;
    }

    public function supperAttack(?int $enemyHp):int {}


}