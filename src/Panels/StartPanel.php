<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use Hyperdrive\Galaxy\GalaxyAtlas\GalaxyAtlas;
use Hyperdrive\Galaxy\Geography\Route;
use Hyperdrive\Player\Pilot\Pilot;
use Hyperdrive\Player\Spaceship\Spaceship;
use Hyperdrive\Player\Spaceship\SpaceshipsCollection;
use Illuminate\Support\Collection;

class StartPanel extends BasePanel
{
    public function selectPilot(Collection $collection): Pilot
    {
        $this->cli->info("Select Your Pilot");
        $pilot = $this->cli->radio("Select Pilot", $collection->toArray())->prompt();
        $this->cli->info("Your Select {$pilot}.");
        return $pilot;
    }

    public function selectSpaceship(SpaceshipsCollection $spaceshipsCollection): Spaceship
    {
        $this->cli->table($spaceshipsCollection->getSpaceshipsData());
        $this->cli->info("Select Your Spaceship");

        $spaceship = $this->cli->radio("Select Spaceship", $spaceshipsCollection->toArray())->prompt();
        $this->cli->info("Your Select {$spaceship}.");
        return $spaceship;
    }

    public function selectRoute(GalaxyAtlas $galaxyAtlas): Route
    {
        $this->cli->info("Select Your Route of Galaxy");

        $route = $this->cli->radio("Select Route", $galaxyAtlas->toArray())->prompt();
        $this->cli->info("Your Select {$route}.");
        return $route;
    }
}
