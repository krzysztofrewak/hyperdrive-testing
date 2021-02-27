<?php

declare(strict_types=1);

namespace Hyperdrive\Handlers;

use League\CLImate\CLImate;

trait TravelHandler
{
    public function choosePlanet(): string
    {
        $currentPlanet = $this->state->currentPlanet;
        $planet = $this->builtAssets->getAtlas()->getPlanet($currentPlanet);
        $neighbours = $planet->getNeighbours();
        $options = [];
        foreach ($neighbours as $neighbour) {
            $options[$neighbour->getId()] = $neighbour->getId();
        }
        $cli = new CLImate();
        return $cli->radio("Choose planet", $options)->prompt();
    }
}