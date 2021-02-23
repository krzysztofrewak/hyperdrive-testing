<?php


namespace Hyperdrive\Entity\Players;


class Capitan extends Player
{
    public function __construct(int $power, int $armor, string $name, int $exp)
    {
        parent::__construct($power, $armor, $name, $exp);
    }

    public function __toString():string
    {
        return $this->getName();
    }


    public function getPower(): int
    {
        return parent::getPower();
    }

    public function setPower(int $power): void
    {
        parent::setPower($power);
    }

    public function getArmor(): int
    {
        return parent::getArmor();
    }

    public function setArmor(int $armor): void
    {
        parent::setArmor($armor);
    }

    public function getName(): string
    {
        return parent::getName();
    }

    public function setName(string $name): void
    {
        parent::setName($name);
    }

    public function getExp(): int
    {
        return parent::getExp();
    }

    public function setExp(int $exp): void
    {
        parent::setExp($exp);
    }

    public function supperAttack(?int $enemyHp): int
    {
        return ceil(($enemyHp * $this->getPower()) / 100);
    }

}