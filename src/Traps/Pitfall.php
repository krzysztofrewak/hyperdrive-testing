<?php

declare(strict_types=1);

namespace Hyperdrive\Traps;

use Hyperdrive\Entity\Person;

class Pitfall {
    public function trap($hyperdriveNavigator, $ship, $quest,Person $person){

        $trap = new Trap();
        $rand = rand(0,20);

        switch ($rand){
            case 0:
                $person->setToken(rand(1,4));
                break;
            case 1:
                $person->setToken(rand(-2,-5));
                break;
            case 2:
                $trap->goToRandomPlanet($hyperdriveNavigator);
                break;
            case 3:
                $trap->enemyOnWay($ship, $quest, $person);
                break;
            case 4:
                $trap->quiz($ship);
                break;
        }

    }
}