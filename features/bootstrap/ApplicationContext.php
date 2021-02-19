<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Hyperdrive\Galaxy\GalaxyAtlas\GalaxyAtlasBuilder;
use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Galaxy\Geography\Route;
use Hyperdrive\Player\Navigator\HyperdriveNavigator;
use PHPUnit\Framework\Assert;

class ApplicationContext implements Context
{
    protected Route $route;
    protected HyperdriveNavigator $navigator;

    /**
     * @Given there's an route built from array:
     * @param TableNode $table
     */
    public function thereSAnRouteBuildFromArray(TableNode $table): void
    {
        $data = collect($table->getHash())->mapWithKeys(fn(array $route): array => [
            "name" => $route["route"],
            "planets" => explode(", ", $route["planets"]),
        ]);

        $this->route = GalaxyAtlasBuilder::buildRouteFromArray($data->toArray());

    }

    /**
     * @Given given route is mounted in a navigator instance
     */
    public function givenRouteIsMountedInANavigatorInstance(): void
    {
        $this->navigator = new HyperdriveNavigator($this->route);
    }

    /**
     * @When :planet is first selected planet
     * @param string $planet
     */
    public function isFirstSelectedPlanet(string $planet): void
    {
        $planet = $this->route->getPlanetByName($planet);
        $this->navigator->jumpTo($planet);
    }

    /**
     * @Then current planet should have following neighbors:
     * @param TableNode $table
     */
    public function currentPlanetShouldHaveFollowingNeighbors(TableNode $table): void
    {
        $planet = $this->navigator->getCurrentPlanet();
        $neighbors = $planet->getNeighbours()->map(fn(Planet $planet): string => (string)$planet);

        Assert::assertEquals($neighbors, $planet->getNeighbours());
    }
}