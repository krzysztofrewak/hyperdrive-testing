<?php

declare(strict_types=1);

namespace Hyperdrive\Geography;

use Hyperdrive\Entity\Person;
use Hyperdrive\Entity\Quest;
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

    public function completeShipStatus(SpaceShip $ship, Person $person) {
        $cli = new CLImate();
        $cli->info("my Cash: ".$person->getCash());
        $options = ["fuel" => "Refuel (15$)", "repair" => "Repair ship (20$)", "nothing" => "Nothing"];
        $result = $cli->radio("Do you want to refuel or repair ship ?", $options)->prompt();
        if($result === "fuel"){
            if ($person->getCash() >= 15){
                $ship->setFuel(15);
                $cli->info("Added +15% fuel! Total fuel: ".$ship->getFuel());
                $person->setCash(-15);
            } else $cli->info("Sorry you have no 15$");
        }else if($result === "repair") {
            if ($person->getCash() >= 20){
                $ship->setCondition(20);
                $cli->info("The ship has been repaired: ".$ship->getCondition()."\n");
                $person->setCash(-20);
            } else $cli->info("Sorry you have no 20$");
        }
    }

    public function enemyOnWay(SpaceShip $ship,Quest $quest, $person){
        $combat = new Combat();
        $cli = new CLImate();
        $enemy = $combat->selectEnemy();

        while(true) {

            for($i=0;$i<20;$i++){
                echo $ship->getInfo();
                echo $enemy;
                echo "\n Round ".($i + 1)."\n";
                if($i % 2 ==0) {
                    $combat->attackEnemy($cli, $enemy, $ship, $quest, $person);
                    if($enemy->getCondition() <=0 || $ship->getCondition() <= 0 ) break;
                }
                else {
                    $combat->enemyAttackYou($ship, $enemy);
                    if($enemy->getCondition() <=0 || $ship->getCondition() <= 0 ) break;
                }
                sleep(2);
            }
            if($enemy->getCondition() <=0 ) {
                $cli->info("\nYou have defeated the enemy!");

                $quest->getDefeatEnemy()->missionStatement($ship, $person);
                // zabiłeś wroga
                // Defeat Enemy BONUS
                break;
            }else {
                $cli->info("\nEnemy has defeated you!");
                break;
            }
        }

    }

    public function getAward(SpaceShip $ship, Person $person){
        $cli = new CLImate();
        $rand = rand(5,20);
        $options = [
            "refuel" => "Refuel:(".$rand."%)",
            "fix" => "Repair ship: (".$rand."%)",
            "money" => "Take Money: (".$rand."$)"
        ];
        echo "\nMy Cash: ".$person->getCash()."$\n";
        $result = $cli->radio("\nSelect your prize: ", $options)->prompt();

        if($result === "refuel") {
            $ship->setFuel($rand);
            echo "Fuel +".$rand."%";
        } else if($result === "fix"){
            $ship->setCondition($rand);
            echo "Ship condition +".$rand."%";
        }else {
            $person->setCash($rand);
            echo "Cash +".$rand."$";
        }
    }

}