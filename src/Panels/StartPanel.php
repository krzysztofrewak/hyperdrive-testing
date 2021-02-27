<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use Hyperdrive\Galaxy\GalaxyAtlas\GalaxyAtlas;
use Hyperdrive\Galaxy\GalaxyAtlas\GalaxyAtlasBuilder;
use Hyperdrive\Galaxy\Geography\Route;
use Hyperdrive\Level\Level;
use Hyperdrive\Level\LevelsBuilder;
use Hyperdrive\Player\Pilot\Pilot;
use Hyperdrive\Player\Pilot\PilotsBuilder;
use Hyperdrive\Player\Spaceship\Spaceship;
use Hyperdrive\Player\Spaceship\SpaceshipsBuilder;
use Hyperdrive\Resources\Level\LevelCollectionResource;
use Hyperdrive\Resources\Spaceship\SpaceshipCollectionResource;
use Illuminate\Support\Collection;

class StartPanel extends BasePanel
{
    protected Collection $pilots;
    protected GalaxyAtlas $atlas;
    protected Collection $spaceships;
    protected Collection $levels;

    public function __construct()
    {
        parent::__construct();
        $this->levels = LevelsBuilder::buildFromYaml("./resources/levels.yaml");
        $this->spaceships = SpaceshipsBuilder::buildFromYaml("./resources/spaceships.yaml");
        $this->atlas = GalaxyAtlasBuilder::buildFromYaml("./resources/routes.yaml");
        $this->pilots = PilotsBuilder::buildFromYaml("./resources/pilots.yaml");
    }

    public function selectDifficultyLevel(): Level
    {
        $levelCollectionResource = new LevelCollectionResource();
        $this->cli->table($levelCollectionResource($this->levels));

        $this->cli->info("Select Your Difficulty Level");
        $level = $this->cli->radio("Select Difficulty Level", $this->levels->toArray())->prompt();
        $this->cli->info("Your Select {$level}.");

        return $level;
    }

    public function selectPilot(): Pilot
    {
        $this->cli->info("Select Your Pilot");
        $pilot = $this->cli->radio("Select Pilot", $this->pilots->toArray())->prompt();
        $this->cli->info("Your Select {$pilot}.");

        return $pilot;
    }

    public function selectSpaceship(): Spaceship
    {
        $spaceshipCollectionResource = new SpaceshipCollectionResource();
        $this->cli->table($spaceshipCollectionResource($this->spaceships));

        $this->cli->info("Select Your Spaceship");
        $spaceship = $this->cli->radio("Select Spaceship", $this->spaceships->toArray())->prompt();
        $this->cli->info("Your Select {$spaceship}.");

        return $spaceship;
    }

    public function selectRoute(): Route
    {
        $this->cli->info("Select Your Route of Galaxy");
        $route = $this->cli->radio("Select Route", $this->atlas->toArray())->prompt();
        $this->cli->info("Your Select {$route}.");

        return $route;
    }
}
