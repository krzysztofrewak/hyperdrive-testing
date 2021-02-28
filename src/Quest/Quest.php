<?php

declare(strict_types=1);

namespace Hyperdrive\Quest;

use Hyperdrive\Geography\Planet;
use JetBrains\PhpStorm\Pure;


class Quest
{
    private Cargo $cargo;
    private Planet $destination;
    private bool $completed;
    private bool $main;
    private int $exp;
    private int $reward;


    public function __construct(Cargo $cargo, Planet $destination, bool $completed, bool $main, int $exp, int $reward)
    {
        $this->cargo = $cargo;
        $this->destination = $destination;
        $this->completed = $completed;
        $this->main = $main;
        $this->exp = $exp;
        $this->reward = $reward;
    }

    #[Pure] public function mainToString(): string
    {
        if (!$this->isMain()) {
            return "Side Quest";
        } else {
            return "Main Quest";
        }
    }

    public function getCargo(): Cargo
    {
        return $this->cargo;
    }

    public function getDestination(): Planet
    {
        return $this->destination;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }

    public function isMain(): bool
    {
        return $this->main;
    }

    public function getExp(): int
    {
        return $this->exp;
    }

    public function getReward(): int
    {
        return $this->reward;
    }
}
