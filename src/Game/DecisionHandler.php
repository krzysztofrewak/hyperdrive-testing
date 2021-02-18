<?php

declare(strict_types=1);

namespace Hyperdrive\Game;

use Hyperdrive\GameData\Missions\Intro;

class DecisionHandler
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getHandler()
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

        return $handler;
    }
}