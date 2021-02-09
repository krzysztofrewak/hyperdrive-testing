<?php

declare(strict_types=1);

namespace Hyperdrive\Quest;

use Hyperdrive\Geography\Planet;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Boolean;


class Quest
{
    private Cargo $cargo;
    private Planet $destination;
    private Bool $completed = false;
    private Bool $main = false;
    private int $exp;
    private int $reward;

    /**
     * Quest constructor.
     * @param Cargo $cargo
     * @param Planet $destination
     * @param bool $completed
     * @param bool $main
     * @param int $exp
     * @param int $reward
     */
    public function __construct(Cargo $cargo, Planet $destination, bool $completed, bool $main, int $exp, int $reward)
    {
        $this->cargo = $cargo;
        $this->destination = $destination;
        $this->completed = $completed;
        $this->main = $main;
        $this->exp = $exp;
        $this->reward = $reward;
    }


    public function completionToString() :string
    {
        if(!$this->isCompleted()){
            return "No";
        }
        else{
            return "Yes";
        }
    }

    public function mainToString() :string
    {
        if(!$this->isMain()){
            return "Side Quest";
        }
        else{
            return "Main Quest";
        }
    }

    /**
     * @return Cargo
     */
    public function getCargo(): Cargo
    {
        return $this->cargo;
    }

    /**
     * @param Cargo $cargo
     */
    public function setCargo(Cargo $cargo): void
    {
        $this->cargo = $cargo;
    }

    /**
     * @return Planet
     */
    public function getDestination(): Planet
    {
        return $this->destination;
    }

    /**
     * @param Planet $destination
     */
    public function setDestination(Planet $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * @param bool $completed
     */
    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }

    /**
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->main;
    }

    /**
     * @param bool $main
     */
    public function setMain(bool $main): void
    {
        $this->main = $main;
    }

    /**
     * @return int
     */
    public function getExp(): int
    {
        return $this->exp;
    }

    /**
     * @param int $exp
     */
    public function setExp(int $exp): void
    {
        $this->exp = $exp;
    }

    /**
     * @return int
     */
    public function getReward(): int
    {
        return $this->reward;
    }

    /**
     * @param int $reward
     */
    public function setReward(int $reward): void
    {
        $this->reward = $reward;
    }





}
