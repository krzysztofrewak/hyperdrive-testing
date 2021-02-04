<?php

declare(strict_types=1);

namespace Hyperdrive\Fight;


use Hyperdrive\Entity\Enemy;
use Hyperdrive\Ship\SpaceShip;
use Hyperdrive\Ship\Weapons\Bombs;
use Hyperdrive\Ship\Weapons\Fire;
use Hyperdrive\Ship\Weapons\Lasers;

class Combat
{
    public function selectEnemy(): ?Enemy
    {
        $randWeapon = rand(1,3);
        $randDmg = rand(10,13);
        $enemy = null;
        if ($randWeapon == 1) $enemy = new Enemy($randDmg,100, new Bombs(rand(15,20),"Bombs"));
        if ($randWeapon == 2) $enemy = new Enemy($randDmg,100, new Fire(rand(15,20),"Fire"));
        if ($randWeapon == 3) $enemy = new Enemy($randDmg,100, new Lasers(rand(15,20), "Lasers"));

        return $enemy;
    }

    public function attackEnemy($cli, Enemy $enemy, SpaceShip $ship){
        $options = [
            "bombs" => $this->getWeaponInfo(0,$ship),
            "fire" => $this->getWeaponInfo(1,$ship),
            "laser" => $this->getWeaponInfo(2,$ship),
            "attack" => "Normal attack (dmg: ".$ship->getPower().")",
        ];
        $result = $cli->radio("Select your weapon ?", $options)->prompt();

        if($result === "bombs") {
            $this->getDamageInfo($enemy,$ship,0);
        } else if ($result === "fire"){
            $this->getDamageInfo($enemy,$ship,1);
        }else if($result === "laser"){
            $this->getDamageInfo($enemy,$ship,2);
        }else {
            $enemy->setCondition($ship->getPower());
            echo "You hit for ".$ship->getPower()." damage";
        }

    }

    private function getWeaponInfo(int $index,SpaceShip $ship): string {
        return "Use ".$ship->getWeaponsName($index)." (dmg: ".$ship->getWeaponsDMG($index).") \n    Condition : -".floor($ship->getWeaponsDMG($index)/5);
    }

    private function getDamageInfo(Enemy $enemy,SpaceShip $ship, int $index): void {
        $enemy->setCondition($ship->getWeaponsDMG($index));
        $ship->setCondition(-(int)floor($ship->getWeaponsDMG($index) / 5));
        echo "You hit for ".$ship->getWeaponsDMG($index)." damage";
    }

    public function enemyAttackYou(SpaceShip $ship, Enemy $enemy){
        $drawAttract = rand(1,3);
        if($drawAttract == 1){
            echo "Enemy use ".$enemy->getWeapon()->getName()." damage: ".$enemy->getWeapon()->getDmg();
            $ship->setCondition(-($enemy->getWeapon()->getDmg()));
        } else {
            $ship->setCondition(-($enemy->getPower()));
            echo "You got ".$ship->getPower()." damage from enemy";
        }
    }
}