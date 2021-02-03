<?php

declare(strict_types = 1);

require "./vendor/autoload.php";

use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\HyperdriveNavigator;
use League\CLImate\CLImate;

$cli = new CLImate();

$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$hyperdrive = new HyperdriveNavigator($atlas);

$target = $hyperdrive->getRandomPlanet();
$cli->info("Your target is the ".$target->getName());

$planet = $hyperdrive->getRandomPlanet();

$person = new \Hyperdrive\Geography\Person();
$spaceShip = new \Hyperdrive\Geography\SpaceShip();
$trap = new \Hyperdrive\Geography\Trap();

$planetToTransportItem = (string)$atlas->getRandomPlanet();
$spaceShip->setTarget($planetToTransportItem);
$spaceShip->setItemToTransport("Natrium");
$cli->info("Target to transport ".$spaceShip->getItemToTransport(). " is ".$spaceShip->getTarget()."\n");

while (true) {
    $person->trap($hyperdrive);
    $randFailure = rand(-2,-5);
    $spaceShip->setFuel($randFailure);
    $spaceShip->setCondition($randFailure);
    $planet = $hyperdrive->getCurrentPlanet();
    $cli->info("".$spaceShip);

    $person->setToken(-($planet->getPrice()));
    echo "\nToken count: ".$person->getToken()."\n";

    if(mb_strtolower(mb_substr($planet->getName(), -1)) == 'a') {
        $trap->getFuel($spaceShip,$person);
    }

    if($planet === $planetToTransportItem) {
        if($spaceShip->getFuel()<=90) $spaceShip->setFuel(rand(1,10));
        if($spaceShip->getCondition()<=90) $spaceShip->setCondition(rand(1,10));
        $trap->unloading();
        $spaceShip->setItemToTransport(null);
    }

    if($person->getToken() <= 0) {
        $cli->info("Sorry you have no token: ".$person->getToken());
        break;
    }else if ($spaceShip->getCondition() <= 0 || $spaceShip->getFuel() <= 0) {
        $cli->info("You have problem with Space Ship, You can't go on ");
        break;
    }
    else if ($planet === $target) {
        $cli->info("You reached the ".$target->getName()."!");
        break;
    }

    $cli->info("You're on the ".$planet->getName(). " You can jump to:");
    $options = $planet->getNeighbours()->toArray() + ["" => "[show more option]"];
    $result = $cli->radio("Select jump target planet", $options)->prompt();

    if (!$result) {
        $options = ["return" => "return", "logs" => "show Logs", "quit" => "quit application"];
        $result = $cli->radio("Select option", $options)->prompt();

        if ($result === "quit") {
            break;
        }else if($result === "logs") {
            $person->getLogs();
            continue;
        }
        continue;
    }

    $person->setLogs($planet);
    $hyperdrive->jumpTo($result);
}
