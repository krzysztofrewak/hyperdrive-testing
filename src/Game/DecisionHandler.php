<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GameData\Missions\Intro;
use Hyperdrive\GameData\Missions\Mission1;

class DecisionHandler
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getUniqueHandler()
    {
        $handler = null;

        if ($this->id === "intro") {
            $handler = new Intro();
        }

        if ($this->id === "mission1") {
            $handler = new Mission1();
        }

        if ($this->id === "mission2") {
            $handler = new Mission2();
        }

        $handler->init();
        return $handler;
    }
}