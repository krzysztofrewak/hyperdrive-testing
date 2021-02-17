<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\GalaxyAtlas\GalaxyAtlas;
use Hyperdrive\Navigator\HyperdriveNavigator;
use Hyperdrive\Player\Player;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;

class GameInstance
{
    protected CLImate $cli;
    protected Player $player;
    protected GalaxyAtlas $atlas;
    protected Collection $pilots;

    public function __construct(GalaxyAtlas $atlas, Collection $pilots)
    {
        $this->atlas = $atlas;
        $this->pilots = $pilots;
        $this->cli = new CLImate();
    }

    public function start(): void
    {
        $this->cli->info("Select Your Pilot");
        $options = $this->pilots->toArray();
        $result =$this->cli->radio("Select Pilot", $options)->prompt();

        $this->player = new Player($result, new HyperdriveNavigator($this->atlas));

        $this->cli->info("Your target is the {$this->player->getTargetPlanet()}.");

        while (true) {
            if ($this->player->checkPlanetsEquals()) {
                $this->cli->info("You reached the {$this->player->getTargetPlanet()}!");
                break;
            }

            $this->cli->info("You're on the {$this->player->getCurrentPlanet()}. You can jump to:");

            $options = $this->player->getCurrentPlanet()->getNeighbours()->toArray() + [
                "more" => "[show more option]",
            ];
            $result = $this->cli->radio("Select jump target planet", $options)->prompt();

            if ($result === "more") {
                $options = [
                    "return" => "return",
                    "quit" => "quit application",
                ];
                $result = $this->cli->radio("Select option", $options)->prompt();

                if ($result === "quit") {
                    break;
                }
                continue;
            }

            $this->player->jumpToPlanet($result);
        }
    }
}
