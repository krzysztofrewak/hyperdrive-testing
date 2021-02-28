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
use League\CLImate\CLImate;

$cli = new Output(new CLImate());

$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$hyperdrive = new HyperdriveNavigator(atlas: $atlas);
$player = new Pilot(name: "placeholder", reputation: 0, skill: 0, credits: 0, exp: 0,output: $cli);
$playerShip = new Ship(output: $cli, name: "placeholder", maxFuel: 0, maxHullIntegrity: 0, maxShields: 0, missileDamage: 0, laserDamage: 0);
$selection = new CharacterSelection(output: $cli);
$selection->characterSelection($player,$playerShip);
$story = new Story(output: $cli);
$questlog = new QuestLog(output: $cli,story: $story);
$questlog->generateStartingQuests($hyperdrive);
$event = new Event(output: $cli);

while (true) {
    $planet = $hyperdrive->getCurrentPlanet();

    $cli->info("");
    $cli->info("You're on the $planet. You can jump to:");
    $cli->info("Remaining fuel: ".$playerShip->getFuel());
    $cli->info("");
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
            $event->randomLandEvents(player: $player, playerShip: $playerShip, currentPlanet: $planet, randomPlanet: $hyperdrive->getRandomPlanet(), questlog: $questlog);
            $surface->whatToDo(hyperdrive: $hyperdrive, playerShip: $playerShip,player: $player,questlog: $questlog);
        }
        if ($result === "quit") {
            break;
        }
        continue;
    }

    $hyperdrive->jumpTo($playerShip,$result);
    $questlog->checkIfCompleted($player,$result);
    $event->randomSpaceEvents(player: $player, playerShip: $playerShip, currentPlanet: $planet, randomPlanet: $hyperdrive->getRandomPlanet(), questlog: $questlog);


}
