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
$hyperdrive = new HyperdriveNavigator($atlas);
$player = new Pilot("placeholder",0,0,0);
$playerShip = new Ship("placeholder",0,0,0,0,0,0,0,0);
$selection = new CharacterSelection();
$selection->characterSelection($player,$playerShip,$cli);
$questlog = new QuestLog();
$questlog->addQuests($hyperdrive);

while (true) {
    $planet = $hyperdrive->getCurrentPlanet();

    if ($questlog->AreAllQuestsCompleted()) {
        $cli->info("You completed all your quests!");
        break;
    }

    $cli->info("You're on the $planet. You can jump to:");
    $options = $planet->getNeighbours()->toArray() + ["" => "[show more option]"];
    $result = $cli->radio("Select jump target planet", $options)->prompt();

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

    $hyperdrive->jumpTo($result);
    $questlog->checkIfCompleted($result);
}
