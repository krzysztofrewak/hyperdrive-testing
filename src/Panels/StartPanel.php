<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use Hyperdrive\Player\Pilot\Pilot;
use Hyperdrive\Player\Spaceship\Spaceship;
use Hyperdrive\Player\Spaceship\SpaceshipsCollection;
use Illuminate\Support\Collection;

class StartPanel extends BasePanel
{
    public function selectPilot(Collection $pilots): Pilot
    {
        $this->cli->info("Select Your Pilot");
        $pilot = $this->cli->radio("Select Pilot", $pilots->toArray())->prompt();
        $this->cli->info("Your Select {$pilot}.");
        return $pilot;
    }

    public function selectSpaceship(SpaceshipsCollection $spaceships): Spaceship
    {
        $this->cli->table($spaceships->getSpaceshipsData());
        $this->cli->info("Select Your Spaceship");
        $spaceship = $this->cli->radio("Select Spaceship", $spaceships->toArray())->prompt();
        $this->cli->info("Your Select {$spaceship}.");
        return $spaceship;
    }
}
