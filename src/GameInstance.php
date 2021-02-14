<?php

declare(strict_types=1);

namespace Hyperdrive;

use Hyperdrive\GalaxyAtlas\GalaxyAtlas;
use Hyperdrive\GalaxyAtlas\GalaxyAtlasBuilder;
use Hyperdrive\Geography\Planet;
use Hyperdrive\Navigator\HyperdriveNavigator;
use League\CLImate\CLImate;

class GameInstance
{
    protected CLImate $cli;
    protected GalaxyAtlas $atlas;
    protected HyperdriveNavigator $navigator;
    protected Planet $targetPlanet;
    protected Planet $currentPlanet;

    public function __construct(private string $filePath = "./resources/routes.yaml")
    {
        $this->cli = new CLImate();
        $this->atlas = GalaxyAtlasBuilder::buildFromYaml($this->filePath);
        $this->navigator = new HyperdriveNavigator($this->atlas);
        $this->targetPlanet = $this->navigator->getRandomPlanet();
        $this->currentPlanet = $this->navigator->getRandomPlanet();
    }

    public function start(): void
    {
        $this->cli->info("Your target is the {$this->targetPlanet}.");

        while (true) {
            if ($this->currentPlanet === $this->targetPlanet) {
                $this->cli->info("You reached the {$this->targetPlanet}!");
                break;
            }

            $this->cli->info("You're on the {$this->currentPlanet}. You can jump to:");

            $options = $this->currentPlanet->getNeighbours()->toArray() + [
                "more" => "[show more option]",
            ];
            $result = $this->selectOption("Select jump target planet", $options);

            if ($result === "more") {
                $options = [
                    "return" => "return",
                    "quit" => "quit application",
                ];
                $result = $this->selectOption("Select option", $options);

                if ($result === "quit") {
                    break;
                }
                continue;
            }

            $this->navigator->jumpTo($result);
            $this->currentPlanet = $this->navigator->getCurrentPlanet();
        }
    }

    private function selectOption(string $message, array $options): string|Planet
    {
        return $this->cli->radio($message, $options)->prompt();
    }
}
