<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\GalaxyAtlas\GalaxyAtlas;
use Hyperdrive\Panels\MainPanel;
use Hyperdrive\Panels\StartPanel;
use Hyperdrive\Player\Navigator\HyperdriveNavigator;
use Hyperdrive\Player\Player;
use Hyperdrive\Player\Spaceship\SpaceshipsCollection;
use Illuminate\Support\Collection;
use Symfony\Component\Config\Definition\Exception\Exception;

class Game
{
    protected Player $player;

    public function __construct(
        protected GalaxyAtlas $atlas,
        protected Collection $pilots,
        protected SpaceshipsCollection $spaceships
    ) {
    }

    public function start(): void
    {
        $this->createPlayer();
        $mainPanel = new MainPanel($this->player);
        $mainPanel->showTarget();

        try {
            while (true) {
                $mainPanel->ifReachedTarget();
                $mainPanel->showCurrentPlanet();
                $mainPanel->selectionSection();
            }
        } catch (Exception $exception) {
            $mainPanel->showException($exception);
        }
    }

    private function createPlayer(): void
    {
        $startPanel = new StartPanel();
        $pilot = $startPanel->selectPilot($this->pilots);
        $spaceship = $startPanel->selectSpaceship($this->spaceships);
        $this->player = new Player($pilot, $spaceship, new HyperdriveNavigator($this->atlas));
    }
}
