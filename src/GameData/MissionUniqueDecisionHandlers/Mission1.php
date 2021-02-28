<?php

declare(strict_types=1);

namespace Hyperdrive\GameData\MissionUniqueDecisionHandlers;

use Hyperdrive\Handlers\TextHandler;
use Hyperdrive\Modules\Combat\Combat;

class Mission1 extends BaseDecisionHandler
{
    use TextHandler;
    use Combat;

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

            if ($decision === "ghorman") {
                $planet = $this->builtAssets->getAtlas()->getPlanet("ghorman");
                $this->state->currentPlanet = "ghorman";
                $this->builtAssets->getHyperdrive()->jumpTo($planet);
                $this->toggleProgress();
                break;
            }

            if ($decision === "proceed") {
                $this->toggleProgress();
                break;
            }

            if ($decision === "elevatorClose") {
                $this->typewriterEffect("You have chosen closer elevator.");
                $this->loadingEffect("Waiting for the elevator");
                $this->typewriterEffect("Looks like it is empty here.");
                $this->typewriterEffect("For now.");
                $this->toggleProgress();
                break;
            }

            if ($decision === "elevatorFar") {
                $this->typewriterEffect("You have chosen further elevator.");
                $this->typewriterEffect("Walking  through this crowd won't be easy.");
                $this->loadingEffect("Walking through the crowd");
                $this->typewriterEffect("You are finally at the elevator.");
                $this->loadingEffect("Waiting for the elevator");
                $this->toggleProgress();
                break;
            }

            if ($decision === "run") {
                $this->loadingEffect("Running");
                $this->toggleProgress();
                break;
            }

            if ($decision === "sneak") {
                $this->loadingEffect("Sneaking", 6);
                $this->toggleProgress();
                break;
            }

            if ($decision === "engage") {
                $this->setUpCombatEnvironment(1);
                $this->setUpEnemyTeam(3, 3);
                $this->setUpFriendlyTeam($this->state->player, $this->state->friend1, $this->state->friend2);
                $this->startCombat();
                if ($this->hasPlayerWon()) {
                    $this->toggleProgress();
                }
                break;
            }

            if ($decision === "bribe") {
                $this->typewriterEffect("- 20 000 credits.");
                $this->state->money -= 20000;
                $this->toggleProgress();
                break;
            }

            if ($decision === "coop") {
                $this->typewriterEffect("It will take some time.");
                $this->state->timeSpent += 200;
                $this->loadingEffect("Waiting", 4);
                $this->toggleProgress();
                break;
            }

            if ($decision === "ask") {
                $this->typewriterEffect("It will take some time.");
                $this->state->timeSpent += 400;
                $this->loadingEffect("Explaining", 8);
                $this->toggleProgress();
                break;
            }

            if ($decision === "hack") {
                $this->toggleProgress();
                break;
            }

            if ($decision === "endMission") {
                $this->toggleMissionEnd("mission2");
                break;
            }

            $this->toggleProgress();
            continue;
        }
    }
}
