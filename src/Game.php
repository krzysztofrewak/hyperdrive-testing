<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\Panels\FinalScorePanel;
use Hyperdrive\Panels\MainPanel;
use Hyperdrive\Player\CreatePlayer;
use Hyperdrive\Player\Player;
use Symfony\Component\Config\Definition\Exception\Exception;

class Game
{
    protected ?Player $player;

    public function start(): void
    {
        $this->player = CreatePlayer::create();
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
            $finalScorePanel = new FinalScorePanel($this->player);
            $finalScorePanel->show();
        }
    }
}
