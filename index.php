<?php

declare(strict_types=1);

use Hyperdrive\Game;
use Hyperdrive\Player\Pilot\PilotsBuilder;
use Hyperdrive\Galaxy\GalaxyAtlas\GalaxyAtlasBuilder;
use Hyperdrive\Player\Spaceship\SpaceshipsBuilder;

require "./vendor/autoload.php";

$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$pilots = PilotsBuilder::buildFromYaml("./resources/pilots.yaml");
$spaceships = SpaceshipsBuilder::buildFromYaml("./resources/spaceships.yaml");

(new Game($atlas, $pilots, $spaceships))->start();