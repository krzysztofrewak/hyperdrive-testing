<?php


namespace Hyperdrive\Quests;


use Hyperdrive\Entity\Person;
use Hyperdrive\Geography\Trap;
use Hyperdrive\Interfaces\TasksInterface;
use Hyperdrive\Ship\SpaceShip;

class VisitPlanets implements TasksInterface
{
    private int $countPlanet = 0;

    public function choosePrize(SpaceShip $ship, Person $person)
    {
        $bonus = new Trap();
        $bonus->getAward($ship, $person);
    }

    public function missionStatement(SpaceShip $ship, Person $person)
    {
        echo "\nYou've visited 5 planets\n";
        if ($this->countPlanet == 5) {
            $this->choosePrize($ship,$person);
            $this->countPlanet = 0;
        }
    }

    public function getCountPlanet(): int
    {
        return $this->countPlanet;
    }

    public function setCountPlanet(int $countPlanet): void
    {
        $this->countPlanet += $countPlanet;
    }


}