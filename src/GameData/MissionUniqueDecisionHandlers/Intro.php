<?php

declare(strict_types=1);

namespace Hyperdrive\GameData\MissionUniqueDecisionHandlers;

use Hyperdrive\Handlers\TextHandler;

class Intro extends BaseDecisionHandler
{
    use TextHandler;

    private int $counter = 1;

    public function handleDecision(string $decision): void
    {
        $this->pauseMenu->unsetGameSaveFlag();

        while (true) {
            if ($decision === "pause") {
                $this->pauseMenu->displayMenu();
                $this->pauseMenu->handleMenu();
                break;
            }

            if ($decision === "proceed") {
                $this->toggleProgress();
                break;
            }

            if ($decision === "endMission") {
                $this->toggleMissionEnd("mission1");
                $this->drawBanner("introBanner");
                break;
            }

            $this->toggleProgress();
            continue;
        }
    }
}
