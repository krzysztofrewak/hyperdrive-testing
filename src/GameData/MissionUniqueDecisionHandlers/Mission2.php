<?php

declare(strict_types=1);

namespace Hyperdrive\GameData\MissionUniqueDecisionHandlers;

use Hyperdrive\Handlers\TextHandler;
use Hyperdrive\Handlers\TravelHandler;
use Hyperdrive\MiniJobs\Menu\MiniJobs;

class Mission2 extends BaseDecisionHandler
{
    use MiniJobs;
    use TravelHandler;
    use TextHandler;

    public array $options;

    public function clearOptions(): void
    {
        $this->options = [];
        $this->options["pause"] = "Pause game";
        $this->options["play"] = "Make some money.";
        $this->options["status"] = "Display information about your crew.";
        $this->options["move"] = "Travel to another planet.";
    }

    public function handleDecision(string $decision): void
    {
        while (true) {
            if ($decision === "pause") {
                $this->pauseMenu->displayMenu();
                $this->pauseMenu->handleMenu();
                break;
            }

            if ($decision === "move") {
                $planetName = $this->choosePlanet();
                $planet = $this->builtAssets->getAtlas()->getPlanet($planetName);
                $this->builtAssets->getHyperdrive()->jumpTo($planet);
                $this->state->currentPlanet = $planetName;
                $this->typewriterEffect("You have arrived safely at ${planetName}.");
                break;
            }

            if ($decision === "play") {
                $this->displayJobsMenu();
                break;
            }

            if ($decision === "proceed") {
                //$this->toggleProgress();
                break;
            }

            if ($decision === "endMission") {
                $this->toggleMissionEnd("mission3");
                break;
            }

            $this->displayMenu();
            //$this->toggleProgress();
            continue;
        }
    }
}
