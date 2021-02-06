<?php


namespace Hyperdrive\Quests;


use Hyperdrive\Entity\Person;
use Hyperdrive\Geography\Trap;
use Hyperdrive\Interfaces\TasksInterface;
use Hyperdrive\Ship\SpaceShip;

class DefeatEnemy implements TasksInterface
{

    public function choosePrize(SpaceShip $ship, Person $person)
    {
        $bonus = new Trap();
        $bonus->getAward($ship, $person);
    }

    public function missionStatement(SpaceShip $ship, Person $person)
    {
        echo "\nyou have successfully defeated the enemy\n";
        $this->choosePrize($ship,$person);
    }
}