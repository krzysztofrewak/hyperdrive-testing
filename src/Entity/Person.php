<?php

declare(strict_types=1);

namespace Hyperdrive\Entity;

use Hyperdrive\Geography\Planet;
use Hyperdrive\Geography\Trap;

class Person
{
    protected int $token;
    protected array $logs = [];
    protected int $cash;

    public function __construct()
    {
        $this->token = rand(20,30);
        $this->cash = rand(30,45);
    }

    public function __toString(): string
    {
        return "Price: ".$this->token;
    }

    public function getToken(): int
    {
        return $this->token;
    }

    public function setToken(int $count): void
    {
        if ($count < 0) echo "Subtracted ".$count." tokens. \n";
        else echo "Added ".$count." tokens. \n";

        $this->token += $count;
    }

    public function trap($hyperdriveNavigator,$ship){

        $trap = new Trap();
        $rand = rand(0,20);

        switch ($rand){
            case 0:
                $this->setToken(rand(1,4));
                break;
            case 1:
                $this->setToken(rand(-2,-5));
                break;
            case 2:
                $trap->goToRandomPlanet($hyperdriveNavigator);
                break;
            case 3:
                $trap->enemyOnWay($ship);
                break;
        }

    }

    public function getLogs()
    {
        echo "You visited:\n ";
        array_map(function ($planet) {
            echo $planet." -> ";
        }, $this->logs);
    }


    public function setLogs(Planet $planet): void
    {
        array_push($this->logs,$planet->getName());
    }

    public function getCash(): int
    {
        return $this->cash;
    }

    public function setCash(int $cash): void
    {
        $this->cash += $cash;
    }



}
