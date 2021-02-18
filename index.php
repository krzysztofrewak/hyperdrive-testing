<?php

declare(strict_types=1);

use Hyperdrive\GalaxyAtlas\GalaxyAtlasBuilder;
use Hyperdrive\GameInstance;
use Hyperdrive\Player\Pilot\PilotsBuilder;
use Hyperdrive\Player\Spaceship\SpaceshipsBuilder;

require "./vendor/autoload.php";

$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$pilots = PilotsBuilder::buildFromYaml("./resources/pilots.yaml");
$spaceships = SpaceshipsBuilder::buildFromYaml("./resources/spaceships.yaml");

(new GameInstance($atlas, $pilots, $spaceships))->start();