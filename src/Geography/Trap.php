<?php

declare(strict_types=1);

namespace Hyperdrive\Geography;

use Hyperdrive\Entity\Enemy;
use Hyperdrive\Entity\Person;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Ship\SpaceShip;
use Hyperdrive\Ship\Weapons\Bombs;
use Hyperdrive\Ship\Weapons\Fire;
use Hyperdrive\Ship\Weapons\Lasers;
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

    public function enemyOnWay(){
        $randWeapon = rand(1,3);
        $randDmg = rand(10,21);
        $enemy = null;
        if ($randWeapon == 1) $enemy = new Enemy(30,100, new Bombs($randDmg,"Bombs"));
        if ($randWeapon == 2) $enemy = new Enemy(30,100, new Fire($randDmg,"Fire"));
        if ($randWeapon == 3) $enemy = new Enemy(30,100, new Lasers($randDmg, "Lasers"));
        echo $enemy;
    }

}