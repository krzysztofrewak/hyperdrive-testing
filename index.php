<?php

declare(strict_types = 1);

require "./vendor/autoload.php";

use Hyperdrive\Entity\Person;
use Hyperdrive\Entity\Quest;
use Hyperdrive\Entity\Task;
use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\Game;
use Hyperdrive\Traps\Pitfall;
use Hyperdrive\Traps\Trap;
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
$task = new Task();
$quest = new Quest(new DefeatEnemy(),new SpendTokens(), new UseWeapon(), new VisitPlanets());
$pitfall = new Pitfall();
$game = new Game();
$game->startGame();
$player = $game->getPlayer();

$task->itemToTransport($atlas,$spaceShip,$cli,$planet,$trap);

while (true) {
    $planet = $hyperdrive->getCurrentPlanet();
    $pitfall->trap($hyperdrive,$spaceShip,$quest,$person,$player);
    $task->shipInformation($spaceShip,$cli);
    $task->questMissions($quest,$spaceShip,$person,$planet);

    echo "\nToken count: ".$person->getToken()."\n";

    if(mb_strtolower(mb_substr($planet->getName(), -1)) == 'a') {
        $trap->completeShipStatus($spaceShip,$person);
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

    $task->setPersonItems($person, $planet);
    $hyperdrive->jumpTo($result);
}
