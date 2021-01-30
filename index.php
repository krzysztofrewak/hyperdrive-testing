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
$player = new Pilot("placeholder",0,0);
$party = new Party();
$party->addPilots();

$target = $hyperdrive->getRandomPlanet();

for ($i = 0; $i < $party->getPilots()->count(); $i++) {
    $cli->info("Pilot #".$i.":");
    $cli->out("Name: ".$party->getPilots()->get($i)->getName());
    $cli->out("Reputation: ".$party->getPilots()->get($i)->getReputation()." (More reputation = More difficulties)");
    $cli->out("Skill: ".$party->getPilots()->get($i)->getSkill()." (More skill = Easier Navigation)");
    $cli->out("");
}

$options = ["Mark" => "I'm choosing Mark", "Jack" => "I'm choosing Jack", "John" => "I'm choosing John"];
$result = $cli->radio("Choose your Pilot", $options)->prompt();

if ($result === "Mark") {
    $player->choosePilot($player,$party->getPilots()->get(0));
}
if ($result === "Jack") {
    $player->choosePilot($player,$party->getPilots()->get(1));
}
if ($result === "John") {
    $player->choosePilot($player,$party->getPilots()->get(2));
}

$cli->info("Name: ".$player->getName());
$cli->info("Skill:".$player->getSkill());
$cli->info("Rep:".$player->getReputation());

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
