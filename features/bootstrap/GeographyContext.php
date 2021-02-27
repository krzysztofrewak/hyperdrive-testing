<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Galaxy\Geography\Route;
use PHPUnit\Framework\Assert;

class GeographyContext implements Context
{
    protected Planet $planet;
    protected Route $route;

    /**
     * @When there's a planet named :name
     * @param string $name
     */
    public function thereIsAPlanetNamed(string $name): void
    {
        $this->planet = new Planet($name);
    }

    /**
     * @Then its name should be :name
     * @param string $name
     */
    public function itsNameShouldBe(string $name): void
    {
        Assert::assertEquals($name, $this->planet);
    }

    /**
     * @When there's a planet named :planet with :neighbor neighbor
     * @param string $planet
     * @param string $neighbor
     */
    public function thereSAPlanetNamedWithNeighbor(string $planet, string $neighbor): void
    {
        $this->planet = new Planet($planet);
        $this->planet->addNeighbour(new Planet($neighbor));
    }

    /**
     * @Given its neighbour list should have :number planet
     * @Given its neighbour list should have :number planets
     * @Given its neighbour list should not have any planets
     * @param int $number
     */
    public function itsNeighbourListShouldHavePlanet(int $number = 0): void
    {
        Assert::assertEquals($number, count($this->planet->getNeighbours()));
    }

    /**
     * @Given there's a route named :name with following planets:
     * @param string $name
     * @param TableNode $table
     */
    public function thereSARouteNamedWithFollowingPlanets(string $name, TableNode $table): void
    {
        $this->route = new Route($name);
        collect($table->getHash())->each(function (array $planet): void {
            $this->route->addPlanet(new Planet($planet["name"]));
        });
    }

    /**
     * @Given its planets list should have :number planet
     * @Given its planets list should have :number planets
     * @Given its planets list should not have any planets
     * @param int $number
     */
    public function itsPlanetsListShouldBe(int $number = 0): void
    {
        Assert::assertEquals($number, count($this->route->getPlanets()));
    }

    /**
     * @Given all of its planets should not be connected as neighbors
     */
    public function allOfItsPlanetsShouldNotBeConnectedAsNeighbors(): void
    {
        collect($this->route->getPlanets())->each(function (Planet $planet) {
            Assert::assertEmpty($planet->getNeighbours());
        });
    }
}