<?php

declare(strict_types = 1);

require "./vendor/autoload.php";

use Hyperdrive\Events\Event;
use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Output\Output;
use Hyperdrive\Pilot\CharacterSelection;
use Hyperdrive\Pilot\Pilot;
use Hyperdrive\Ship\Ship;
use Hyperdrive\Quest\QuestLog;
use Hyperdrive\Geography\PlanetSurface;
use Hyperdrive\Story\Story;
use Hyperdrive\Tutorial\Tutorial;
use League\CLImate\CLImate;


$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$hyperdrive = new HyperdriveNavigator(atlas: $atlas);
$cli = new Output(new CLImate());
$player = new Pilot(name: "placeholder", reputation: 0, skill: 0, credits: 0, exp: 0,output: $cli);
$playerShip = new Ship(output: $cli, name: "placeholder", maxFuel: 0, maxHullIntegrity: 200, maxShields: 200, missileDamage: 60, laserDamage: 40);
$selection = new CharacterSelection(output: $cli);
$story = new Story(output: $cli);
$questlog = new QuestLog(output: $cli,story: $story);
$event = new Event(output: $cli);

$options = ["play" => "Start the Game!","tutorial" => "I would like to play the Tutorial first","quit" => "Quit Application"];
$result = $cli->getCli()->radio("Welcome to the main menu:", $options)->prompt();

if ($result === "tutorial") {
    $tutorial = new Tutorial(output: $cli,player: $player,playerShip: $playerShip);
}
if ($result === "quit") {
    exit(0);
}

$selection->characterSelection($player,$playerShip);
$story->intro();
$questlog->generateStartingQuests($hyperdrive);

while (true) {
    $planet = $hyperdrive->getCurrentPlanet();

    $cli->write("");
    $cli->info("You're on the $planet. You can jump to:");
    $cli->write("Remaining fuel: ".$playerShip->getFuel());
    $cli->write("");
    $options = $planet->getNeighbours()->toArray() + ["" => "[show more option]"];
    $result = $cli->getCli()->radio("Select a planet to jump to:", $options)->prompt();


    if (!$result) {
        $options = ["return" => "return","stats" => "show pilot and ship stats","quests" => "show quests","land" => "land on current planet", "quit" => "quit application"];
        $result = $cli->getCli()->radio("Select option:", $options)->prompt();

        if ($result === "quests") {
            $questlog->showQuests();
        }
        if ($result === "stats") {
            $player->showStats();
            $playerShip->showStats();
        }
        if ($result === "land") {
            $surface = new PlanetSurface(output: $cli);
            $event->randomLandEvents(player: $player, playerShip: $playerShip);
            $surface->whatToDo(player: $player, playerShip: $playerShip, hyperdrive: $hyperdrive, questlog: $questlog);
        }
        if ($result === "quit") {
            break;
        }
        continue;
    }

    $hyperdrive->jumpTo($playerShip,$result);
    $questlog->checkIfCompleted($player,$result);
    $event->randomSpaceEvents(player: $player, playerShip: $playerShip,hyperdrive: $hyperdrive, questlog: $questlog, surface: new PlanetSurface(output: $cli),event: $event);


}
