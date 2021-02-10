<?php

declare(strict_types = 1);

require "./vendor/autoload.php";

use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Pilot\CharacterSelection;
use Hyperdrive\Pilot\Pilot;
use Illuminate\Support\Collection;
use Hyperdrive\Ship\Ship;
use Hyperdrive\Combat\Combat;
use Hyperdrive\Quest\QuestLog;
use League\CLImate\CLImate;

$cli = new CLImate();

$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$hyperdrive = new HyperdriveNavigator(atlas: $atlas);
$player = new Pilot(name: "placeholder", reputation: 0, skill: 0, credits: 0, exp: 0);
$playerShip = new Ship(name: "placeholder", maxFuel: 0, maxHullIntegrity: 0, maxShields: 0, missileDamage: 0, laserDamage: 0);
$selection = new CharacterSelection(cli: $cli);
$selection->characterSelection($player,$playerShip);
$questlog = new QuestLog();
$questlog->addQuests($hyperdrive);

while (true) {
    $planet = $hyperdrive->getCurrentPlanet();

    if ($questlog->AreAllQuestsCompleted()) {
        $cli->info("You completed all your quests!");
        break;
    }

    $cli->info("You're on the $planet. You can jump to:");
    $cli->info("Remaining fuel: ".$playerShip->getFuel());

    $options = $planet->getNeighbours()->toArray() + ["" => "[show more option]"];
    $result = $cli->radio("Select a planet to jump to:", $options)->prompt();

    if (!$result) {
        $options = ["return" => "return","quests" => "show quests", "quit" => "quit application"];
        $result = $cli->radio("Select option", $options)->prompt();

        if ($result === "quests") {
            $questlog->showQuests($cli);
        }
        if ($result === "quit") {
            break;
        }
        continue;
    }

    $hyperdrive->jumpTo($playerShip,$result);
    $questlog->checkIfCompleted($player,$result,$cli);

}
