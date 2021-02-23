<?php


namespace Hyperdrive\Entity\Players;


use Hyperdrive\Interfaces\PlayerInterface;

class Capitan extends Player implements PlayerInterface
{
    private int $level;
    private int $currentExp;
    public function __construct(int $power, int $armor, string $name, int $exp)
    {
        parent::__construct($power, $armor, $name, $exp);
        $this->level = 1;
        $this->currentExp = 0;
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
        $this->levelUpgrade();
    }

    public function resetExp()
    {
        parent::resetExp();
    }


    public function supperAttack(?int $enemyHp): int
    {
        return ceil(($enemyHp * $this->getPower()) / 100);
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    private function setLevel(){
        $this->level++;

        $attributes = (int)($this->getLevel()*2);
        $this->setArmor($attributes);
        $this->setPower($attributes);

        echo "\n".$this->getName()." Level Up\n"."Armor: ".$this->getArmor()."\nPower: ".$this->getPower();
    }


    public function levelUpgrade():void
    {
        if( $this->getExp() >= 500){
            $this->currentExp = 500 - $this->getExp();
            $this->resetExp();
            $this->setLevel();
            echo "Level UP: ".$this->getLevel()." Lvl";
        }
    }




}