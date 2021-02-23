<?php


namespace Hyperdrive\Quests;


use Hyperdrive\Entity\Players\Player;
use Hyperdrive\Traps\Trap;
use Hyperdrive\Interfaces\TasksInterface;

class UseWeapon implements TasksInterface
{
    private int $weaponCount = 0;


    public function choosePrize($ship, $person)
    {
        $bonus = new Trap();
        $bonus->getAward($ship, $person);
    }

    public function missionStatement($ship, $person, Player $player)
    {
        if ($this->weaponCount == 3) {
            echo "\nYou use weapons 3 times (exp +200)\n";
            $player->setExp(200);
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