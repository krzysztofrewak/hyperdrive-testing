<?php


namespace Hyperdrive\Quests;


use Hyperdrive\Entity\Person;
use Hyperdrive\Entity\Players\Player;
use Hyperdrive\Traps\Trap;
use Hyperdrive\Interfaces\TasksInterface;
use Hyperdrive\Ship\SpaceShip;

class DefeatEnemy implements TasksInterface
{

    public function choosePrize(SpaceShip $ship, Person $person)
    {
        $bonus = new Trap();
        $bonus->getAward($ship, $person);
    }

    public function missionStatement(SpaceShip $ship, Person $person, Player $player)
    {
        echo "\nyou have successfully defeated the enemy (exp +200)\n";
        $player->setExp(200);
        $this->choosePrize($ship,$person);
    }
}