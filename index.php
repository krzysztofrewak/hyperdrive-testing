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
$cli->info("\nYour target is the $target.");

$planet = $hyperdrive->getRandomPlanet();

while (true) {
    $planet = $hyperdrive->getCurrentPlanet();

    if ($planet === $target) {
        $cli->br()->info("You reached the $target!");
        break;
    }

    $cli->br()->info("You're on the $planet. You can jump to:");
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
