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
        $randDmg = rand(10,21);
        $enemy = null;
        if ($randWeapon == 1) $enemy = new Enemy($randDmg,100, new Bombs($randDmg,"Bombs"));
        if ($randWeapon == 2) $enemy = new Enemy($randDmg,100, new Fire($randDmg,"Fire"));
        if ($randWeapon == 3) $enemy = new Enemy($randDmg,100, new Lasers($randDmg, "Lasers"));

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
            $enemy->setCondition($ship->getWeaponsDMG(0));
            $ship->setCondition((int)floor($ship->getWeaponsDMG(0) / 5));
            echo "You hit for ".$ship->getWeaponsDMG(0)." damage";
        } else if ($result === "fire"){
            $enemy->setCondition($ship->getWeaponsDMG(1));
            $ship->setCondition((int)floor($ship->getWeaponsDMG(1) / 5));
            echo "You hit for ".$ship->getWeaponsDMG(1)." damage";
        }else if($result === "laser"){
            $enemy->setCondition($ship->getWeaponsDMG(2));
            $ship->setCondition((int)floor($ship->getWeaponsDMG(2) / 5));
            echo "You hit for ".$ship->getWeaponsDMG(2)." damage";
        }else {
            $enemy->setCondition($ship->getPower());
            echo "You hit for ".$ship->getPower()." damage";
        }

    }

    private function getWeaponInfo(int $index,SpaceShip $ship): string
    {
        return "Use ".$ship->getWeaponsName($index)." (dmg: ".$ship->getWeaponsDMG($index).
            ") \n    Condition : -".floor($ship->getWeaponsDMG($index)/5);
    }
}