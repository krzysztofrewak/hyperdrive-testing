<?php

declare(strict_types=1);

namespace Hyperdrive\Panels;

use Hyperdrive\Contracts\PanelContract;
use Hyperdrive\Galaxy\Geography\Planet;
use Hyperdrive\Panels\Options\HyperspaceJumpOptions;
use Hyperdrive\Player\Navigator\HyperspaceJump;
use Symfony\Component\Config\Definition\Exception\Exception;

class HyperspaceJumpPanel extends BasePanel implements PanelContract
{
    public function __construct(protected HyperspaceJump $hyperspaceJump)
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function selectionSection(): void
    {
        $hyperspaceJumpOptions = new HyperspaceJumpOptions();
        $result = $this->cli->radio("Select option", $hyperspaceJumpOptions())->prompt();

        if ($result === "quit") {
            throw new Exception("Hyperspace jump was canceled");
        }

        $this->hyperspaceJump->setJumpOption($result);
        $planet = $this->selectPlanet();
        $this->hyperspaceJump->jumpTo($planet);
    }

    /**
     * @throws Exception
     */
    private function selectPlanet(): Planet
    {
        $matchingPlanets = $this->hyperspaceJump->getMatchingPlanets();

        if ($matchingPlanets->count() !== 1) {
            return $this->cli->radio("Select planet to hyperspace jump", $matchingPlanets->toArray())->prompt();
        }

        /** @var Planet $planet */
        $planet = $matchingPlanets->get(0);

        $this->cli->error("Only one planet meets the requirements for a hyperspace jump");
        $result = $this->cli->radio("Do you want to jump to {$planet}", ["Yes", "No"])->prompt();

        if ($result === "No") {
            throw new Exception("Hyperspace jump was canceled");
        }

        return $planet;
    }
}
