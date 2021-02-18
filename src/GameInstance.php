<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\GalaxyAtlas\GalaxyAtlas;
use Hyperdrive\Navigator\HyperdriveNavigator;
use Hyperdrive\Player\Player;
use Hyperdrive\Player\Spaceship\SpaceshipsCollection;
use Illuminate\Support\Collection;
use League\CLImate\CLImate;
use Symfony\Component\Config\Definition\Exception\Exception;

class GameInstance
{
    protected CLImate $cli;
    protected Player $player;
    protected GalaxyAtlas $atlas;
    protected Collection $pilots;
    protected SpaceshipsCollection $spaceships;

    public function __construct(GalaxyAtlas $atlas, Collection $pilots, SpaceshipsCollection $spaceships)
    {
        $this->atlas = $atlas;
        $this->pilots = $pilots;
        $this->spaceships = $spaceships;
        $this->cli = new CLImate();
    }

    public function start(): void
    {
        //Select Pilot
        $this->cli->info("Select Your Pilot");
        $options = $this->pilots->toArray();
        $pilot = $this->cli->radio("Select Pilot", $options)->prompt();
        $this->cli->info("Your Select {$pilot}.");

        //Select Spaceship
        $this->cli->table($this->spaceships->getSpaceshipsData());
        $this->cli->info("Select Your Spaceship");
        $options = $this->spaceships->toArray();
        $spaceship = $this->cli->radio("Select Spaceship", $options)->prompt();
        $this->cli->info("Your Select {$spaceship}.");

        //Create Player
        $this->player = new Player($pilot, $spaceship, new HyperdriveNavigator($this->atlas));

        //Show target
        $this->cli->info("Your target is the {$this->player->getTargetPlanet()}.");

        //Game
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
                    "spaceship" => "show spaceship details",
                    "player" => "show player details",
                    "refueling" => "refueling Spaceship",
                    "return" => "return",
                    "quit" => "quit application",
                ];
                $result = $this->cli->radio("Select option", $options)->prompt();

                if ($result === "quit") {
                    break;
                } elseif ($result === "spaceship") {
                    $this->cli->table([$this->player->showSpaceshipData()]);
                } elseif ($result === "refueling") {
                    try {
                        $this->player->refuelingSpaceship();
                    } catch (Exception $exception) {
                        $this->cli->error($exception->getMessage());
                    }
                } elseif ($result === "player") {
                    $this->cli->table([$this->player->showPlayerData()]);
                }
                continue;
            }
            try {
                $this->player->jumpToPlanet($result);
            } catch (Exception $exception) {
                $this->cli->error($exception->getMessage());
            }
        }
    }
}
