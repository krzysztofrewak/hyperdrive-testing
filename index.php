<?php

declare(strict_types = 1);

require "./vendor/autoload.php";

use Hyperdrive\GalaxyAtlasBuilder;
use Hyperdrive\HyperdriveNavigator;
use Hyperdrive\Pilot\Party;
use Hyperdrive\Pilot\Pilot;
use League\CLImate\CLImate;

$cli = new CLImate();

$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$hyperdrive = new HyperdriveNavigator($atlas);

$party = new Party();
$party->addPilots();

$target = $hyperdrive->getRandomPlanet();

$character = $party->getPilots()->toArray();

for ($i = 0; $i < $party->getPilots()->count(); $i++) {
    $cli->info("Pilot #".$i.":");
    $cli->out("Name: ".$party->getPilots()->get($i)->getName());
    $cli->out("Reputation: ".$party->getPilots()->get($i)->getReputation()." (More reputation = More difficulties)");
    $cli->out("Skill: ".$party->getPilots()->get($i)->getSkill()." (More skill = Easier Navigation)");
    $cli->out("");
}


$cli->info("Your target is the $target.");

$planet = $hyperdrive->getRandomPlanet();

while (true) {
    $planet = $hyperdrive->getCurrentPlanet();

    if ($planet === $target) {
        $cli->info("You reached the $target!");
        break;
    }

    $cli->info("You're on the $planet. You can jump to:");
    $options = $planet->getNeighbours()->toArray() + ["" => "[show more option]"];
    $result = $cli->radio("Select jump target planet", $options)->prompt();

    if (!$result) {
        $options = ["return" => "return", "quit" => "quit application"];
        $result = $cli->radio("Select option", $options)->prompt();

        if ($result === "quit") {
            break;
        }
        continue;
    }

    $hyperdrive->jumpTo($result);
}
