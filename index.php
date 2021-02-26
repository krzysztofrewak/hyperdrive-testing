<?php

declare(strict_types = 1);

require "./vendor/autoload.php";

use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Output\Output;
use Hyperdrive\Pilot\CharacterSelection;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Ship\Ship;
use Hyperdrive\Quest\QuestLog;
use Hyperdrive\Geography\PlanetSurface;
use League\CLImate\CLImate;

$cli = new Output(new CLImate());

$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$hyperdrive = new HyperdriveNavigator(atlas: $atlas);
$player = new Pilot(name: "placeholder", reputation: 0, skill: 0, credits: 0, exp: 0,output: $cli);
$playerShip = new Ship(output: $cli, name: "placeholder", maxFuel: 0, maxHullIntegrity: 0, maxShields: 0, missileDamage: 0, laserDamage: 0);
$selection = new CharacterSelection(output: $cli);
$selection->characterSelection($player,$playerShip);
$questlog = new QuestLog(output: $cli);
$questlog->generateStartingQuests($hyperdrive);

while (true) {
    $planet = $hyperdrive->getCurrentPlanet();


    $cli->info("You're on the $planet. You can jump to:");
    $cli->info("Remaining fuel: ".$playerShip->getFuel());

    $options = $planet->getNeighbours()->toArray() + ["" => "[show more option]"];
    $result = $cli->getCli()->radio("Select a planet to jump to:", $options)->prompt();


    if (!$result) {
        $options = ["return" => "return","stats" => "show pilot and ship stats","quests" => "show quests","land" => "land on current planet", "quit" => "quit application"];
        $result = $cli->getCli()->radio("Select option", $options)->prompt();

        if ($result === "quests") {
            $questlog->showQuests();
        }
        if ($result === "stats") {
            $player->showStats();
            $playerShip->showStats();
        }
        if ($result === "land") {
            $surface = new PlanetSurface(output: $cli);
            $surface->whatToDo(hyperdrive: $hyperdrive, playerShip: $playerShip,player: $player,questlog: $questlog);
        }
        if ($result === "quit") {
            break;
        }
        continue;
    }

    $hyperdrive->jumpTo($playerShip,$result);
    $questlog->checkIfCompleted($player,$result);

}
