<?php

declare(strict_types=1);

namespace Hyperdrive\Geography;

use Hyperdrive\Entity\Person;
use Hyperdrive\Fight\Combat;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Ship\SpaceShip;
use League\CLImate\CLImate;

class Trap {

    public function goToRandomPlanet(HyperdriveNavigator $hyperdriveNavigator)
    {
        $cli = new CLImate();
        $randomPlanet = $hyperdriveNavigator->getRandomPlanet();
        $cli->info("You have been transport to ".$randomPlanet."\n");
        return $hyperdriveNavigator->jumpTo($randomPlanet);
    }

    public function unloading() {
        $cli = new CLImate();
        $cli->info("Your target is the ");
        while(true)
        {
            $cli->info("unloading in progress ...");
            sleep(5000);
            $cli->info("everything is ready!");
        }
    }

    public function getFuel(SpaceShip $ship, Person $person) {
        $cli = new CLImate();
        $options = ["Yes" => "Yes", "No" => "No"];
        $result = $cli->radio("Do you want to refuel ?", $options)->prompt();
        $cli->info("Cost 15$");
        if($result === "Yes"){
            if ($person->getCash() >= 15){
                $ship->setFuel(15);
                $cli->info("Added +15% fuel! Total fuel: ".$ship->getFuel());
            } else $cli->info("Sorry you have no 15$");
        }
    }

    public function enemyOnWay(SpaceShip $ship){
        $combat = new Combat();
        $cli = new CLImate();
        $enemy = $combat->selectEnemy();
        echo $enemy;
        echo $ship->getInfo();

        while(true) {

            for($i=0;$i<20;$i++){
                echo $ship->getInfo();
                echo $enemy;
                echo "\n RUNDA ".($i + 1)."\n";
                if($i % 2 ==0) {
                    $combat->attackEnemy($cli, $enemy, $ship);
                    if($enemy->getCondition() <=0 || $ship->getCondition() <= 0 ) break;
                }
                else {
                    $ship->setCondition(-($enemy->getPower()));
                    echo "You got ".$ship->getPower()." damage from enemy";
                    if($enemy->getCondition() <=0 || $ship->getCondition() <= 0 ) break;
                }
                sleep(2);
            }

            if($enemy->getCondition() <=0 || $ship->getCondition() <= 0 ) break; // wykomentowac
        }

    }

}