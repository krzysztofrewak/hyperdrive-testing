<?php


namespace Hyperdrive\Quests;


use Hyperdrive\Geography\Trap;
use Hyperdrive\Interfaces\TasksInterface;
use League\CLImate\CLImate;

class UseWeapon implements TasksInterface
{
    private int $weaponCount = 0;


    public function choosePrize($ship, $person)
    {
        $bonus = new Trap();
        $bonus->getAward($ship, $person);
    }

    public function missionStatement($ship, $person)
    {
        if ($this->weaponCount == 3) {
            echo "\nYou use weapons 3 times\n";
            $this->weaponCount = 0;
            $this->choosePrize($ship, $person);
        }
    }


    public function getWeaponCount(): int
    {
        return $this->weaponCount;
    }

    public function setWeaponCount(int $weaponCount): void
    {
        $this->weaponCount += $weaponCount;
    }


}