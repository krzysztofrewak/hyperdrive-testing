<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use Hyperdrive\Geography\Planet;
use Hyperdrive\Panels\Options\MainOptions;
use Hyperdrive\Player\Player;
use Symfony\Component\Config\Definition\Exception\Exception;

class MainPanel extends BasePanel
{
    public function __construct(
        protected Player $player
    ) {
        parent::__construct();
    }

    public function showTarget(): void
    {
        $this->cli->info("Your target is the {$this->player->getTargetPlanet()}.");
    }

    public function showCurrentPlanet(): void
    {
        $this->cli->info("You're on the {$this->player->getCurrentPlanet()}. You can jump to:");
    }

    /**
     * @throws Exception
     */
    public function ifReachedTarget(): void
    {
        if ($this->player->isPlanetsEqual()) {
            throw new Exception("You reached the {$this->player->getTargetPlanet()}!");
        }
    }

    public function selectionSection(): void
    {
        $mainOptions = new MainOptions();
        $result = $this->cli->radio("Select jump target planet", $mainOptions($this->player))->prompt();

        if ($result instanceof Planet) {
            try {
                $this->player->jumpToPlanet($result);
            } catch (Exception $exception) {
                $this->showException($exception);
            }
        } else {
            $morePanel = new MorePanel($this->player);
            $morePanel->selectionSection();
        }
    }
}
