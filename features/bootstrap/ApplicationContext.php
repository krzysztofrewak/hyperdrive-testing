<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Hyperdrive\GalaxyAtlas\GalaxyAtlas;
use Hyperdrive\GalaxyAtlas\GalaxyAtlasBuilder;
use Hyperdrive\Geography\Planet;
use Hyperdrive\Navigator\HyperdriveNavigator;
use PHPUnit\Framework\Assert;

class ApplicationContext implements Context
{
    protected GalaxyAtlas $atlas;
    protected HyperdriveNavigator $navigator;

    /**
     * @Given there's an atlas built from route array:
     * @param TableNode $table
     */
    public function thereSAnAtlasBuildFromRouteArray(TableNode $table): void
    {
        $routes = collect($table->getHash())->mapWithKeys(fn(array $route): array => [
            $route["route"] => explode(", ", $route["planets"]),
        ]);

        $this->atlas = GalaxyAtlasBuilder::buildFromRoutesArray($routes->toArray());
    }

    /**
     * @Given given atlas is mounted in a navigator instance
     */
    public function givenAtlasIsMountedInANavigatorInstance(): void
    {
        $this->navigator = new HyperdriveNavigator($this->atlas);
    }

    /**
     * @When :planet is first selected planet
     * @param string $planet
     */
    public function isFirstSelectedPlanet(string $planet): void
    {
        $planet = $this->atlas->getPlanet($planet);
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