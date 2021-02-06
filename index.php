<?php

declare(strict_types = 1);

require "./vendor/autoload.php";

use Hyperdrive\Entity\Person;
use Hyperdrive\Entity\Quest;
use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\Geography\Trap;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Quests\DefeatEnemy;
use Hyperdrive\Quests\SpendTokens;
use Hyperdrive\Quests\UseWeapon;
use Hyperdrive\Quests\VisitPlanets;
use League\CLImate\CLImate;

$cli = new CLImate();

$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$hyperdrive = new HyperdriveNavigator($atlas);

$target = $hyperdrive->getRandomPlanet();
$cli->info("Your target is the ".$target->getName());

$planet = $hyperdrive->getRandomPlanet();

$person = new Person();
$spaceShip = new Hyperdrive\Ship\SpaceShip();
$trap = new Trap();
$quest = new Quest(new DefeatEnemy(),new SpendTokens(), new UseWeapon(), new VisitPlanets());

$planetToTransportItem = (string)$atlas->getRandomPlanet();
$spaceShip->setTarget($planetToTransportItem);
$spaceShip->setItemToTransport("Natrium");
$cli->info("Target to transport ".$spaceShip->getItemToTransport(). " is ".$spaceShip->getTarget()."\n");

while (true) {
    $person->trap($hyperdrive,$spaceShip,$quest,$person);
    $spaceShip->setFuel(rand(-2,-8));
    $spaceShip->setCondition(rand(-2,-8));
    $planet = $hyperdrive->getCurrentPlanet();
    $cli->info("".$spaceShip);
    $quest->getVisitPlanets()->missionStatement($spaceShip,$person);
    $quest->getVisitPlanets()->setCountPlanet(1);
    $quest->getSpendTokens()->missionStatement($spaceShip,$person);
    $quest->getSpendTokens()->setTokenCount($planet->getPrice());


    echo "\nToken count: ".$person->getToken()."\n";

    if(mb_strtolower(mb_substr($planet->getName(), -1)) == 'a') {
        $trap->completeShipStatus($spaceShip,$person);
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

    $person->setToken(-($planet->getPrice()));
    $person->setLogs($planet);
    $hyperdrive->jumpTo($result);
}
