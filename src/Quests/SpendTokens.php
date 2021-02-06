<?php


namespace Hyperdrive\Quests;


use Hyperdrive\Entity\Person;
use Hyperdrive\Geography\Trap;
use Hyperdrive\Interfaces\TasksInterface;
use Hyperdrive\Ship\SpaceShip;

class SpendTokens implements TasksInterface
{

    private int $tokenCount = 0;

    public function choosePrize(SpaceShip $ship, Person $person)
    {
        $bonus = new Trap();
        $bonus->getAward($ship, $person);
    }

    public function missionStatement(SpaceShip $ship, Person $person)
    {
        echo "\nYou spend 15 tokens\n";
        if ($this->tokenCount == 15 ){
            $this->choosePrize($ship,$person);
            $this->tokenCount = 0;
        }
    }

    public function getTokenCount(): int
    {
        return $this->tokenCount;
    }

    public function setTokenCount(int $tokenCount): void
    {
        $this->tokenCount += $tokenCount;
    }


}