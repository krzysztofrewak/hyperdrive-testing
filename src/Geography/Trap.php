<?php

declare(strict_types=1);

namespace Hyperdrive\Geography;

use Hyperdrive\Entity\Person;
use Hyperdrive\Entity\Quest;
use Hyperdrive\Fight\Combat;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Ship\SpaceShip;
use Illuminate\Support\Facades\Http;
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
            sleep(5);
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

    public function quiz(SpaceShip $ship){
        $cli = new CLImate();
        $ch = curl_init();
        $url = 'https://opentdb.com/api.php?amount=1&type=multiple';

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($ch);
        if($e = curl_error($ch)){
            echo $e;
        }else {
            $decoded = json_decode($resp);
            $answers = [];
            $correctAnswer = $decoded->{"results"}[0]->{"correct_answer"};
            array_push($answers, $decoded->{"results"}[0]->{"incorrect_answers"});
            array_push($answers[0], $correctAnswer);
            shuffle($answers[0]);
//            print_r("Correct: ".$correctAnswer."\n");
            $question = utf8_encode($decoded->{"results"}[0]->{"question"});
            $options = [
                $answers[0][0] => utf8_encode($answers[0][0]),
                $answers[0][1] => utf8_encode($answers[0][1]),
                $answers[0][2] => utf8_encode($answers[0][2]),
                $answers[0][3] => utf8_encode($answers[0][3]),
                ];
            $result = $cli->radio("To advance to the next planet you must answer the question: \n".$question, $options)->prompt();
            if($result === $correctAnswer){
                $cli->info("Good answer, you can move on !");
            } else {
                $damage = rand(5,10);
                $ship->setCondition(-$damage);
                $cli->info("wrong answer, you take damage: -".$damage);
                echo "Ship condition: ".$ship->getCondition()."\n"."the correct answer is : ".$correctAnswer."\n";
            }
        }

        curl_close($ch);

    }

}