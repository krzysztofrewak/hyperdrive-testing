<?php

declare(strict_types=1);

namespace Hyperdrive\MiniJobs\Menu;

use Hyperdrive\MiniJobs\Foraging\Foraging;
use Hyperdrive\MiniJobs\Poker\Poker;
use League\CLImate\CLImate;

trait MiniJobs
{
    private string $job;

    public function displayJobsMenu()
    {
        $climate = new CLImate();
        $options = [
            "poker" => "5 card poker",
            "foraging" => "Collect whatever you find in the forest and sell it by the highway.",
            "return" => "Return to your duties"
        ];
        $this->job = $climate->radio("How do you want to make money", $options)->prompt();
        $this->handleJobsMenu();
    }

    protected function handleJobsMenu(): void
    {
        $decision = $this->job;

        while (true) {
            if ($decision === "return") {
                break;
            }

            if ($decision === "poker") {
                $poker = new Poker($this->state->player[0], $this->state->money);
                $this->state->money = $poker->getPlayerEarnings();
                break;
            }

            if ($decision === "foraging") {
                $foraging = new Foraging($this->state->player[0], $this->state->money);
                $this->state->money = $foraging->getPlayerEarnings();
            }
        }
    }
}