<?php

declare(strict_types=1);

use Hyperdrive\GalaxyAtlas\GalaxyAtlasBuilder;
use Hyperdrive\GameInstance;
use Hyperdrive\Player\Pilot\PilotsBuilder;

require "./vendor/autoload.php";

$atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
$pilots = PilotsBuilder::buildFromYaml("./resources/pilots.yaml");

(new GameInstance($atlas, $pilots))->start();